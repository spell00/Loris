<?php
/**
 * This script is written for a one time use only to facilitate the normalization of the consent feature of candidate parameters. 
 * 
 * This script imports existing consent data from `participant_status` and `consent_info_history` into new normalized tables.
 * 
 * A SQL file is exported to path: loris_root/SQL/Cleanup_patches/delete_old_consent_tables.sql
 * after running this script. Source this file to delete the now deprecated tables and columns.
 * 
 * affected tables:
 * - participant_status
 * - consent_info_history
 * - consent
 * - candidate_consent_rel
 * - candidate_consent_history
 * 
 * PHP Version 7
 * 
 * @category Main 
 * @package  Loris
 * @author   Zaliqa Rosli <zaliqa.rosli@mcin.ca>
 * @license  Loris license
 * @link     https://github.com/aces/Loris
 */
require_once __DIR__ . '/../generic_includes.php';

$config = \NDB_Config::singleton();
$db     =& \Database::singleton();

// Specify current database
$database = $config->getSetting('database');
$dbName = $database['database'];

// Get consent details from Config.xml
$consentConfig = $config->getSetting('ConsentModule');
$useConsent = $consentConfig['useConsent'];
$consents = $consentConfig['Consent'];

// Format array of consents
foreach(\Utility::toArray($consents) as $consent) {
    $consentName = $consent['name'];
    $consentLabel = $consent['label'];
    $consentList[$consentName] = $consentLabel;
}
///////////////////////////////////////
// VALIDATE EXISTING CONSENT DETAILS //
///////////////////////////////////////

$errors = [];

// Check for when consent columns exist in participant_status but not in Config.xml
$columnQuery = "SELECT Column_name FROM Information_schema.columns
                WHERE Column_name LIKE '%consent%'
                AND Table_name='participant_status'
                AND Table_schema=:currentdb";

$existingColumns = $db->pselect($columnQuery, array('currentdb'=>$dbName));

// Format result to only keep consent name columns
$formattedColumns = [];
foreach ($existingColumns as $column) {
    $columnName = $column['Column_name']; 
    if (!(preg_match("/date/", $columnName) || preg_match("/withdrawal/", $columnName))) {
        array_push($formattedColumns, $columnName);
    }
}
// Check column names are in list of consent names
foreach ($formattedColumns as $columnName) {
    if (!array_key_exists($columnName, $consentList)) {
        array_push(
            $errors, "The consent type " . $columnName . " exists in the database but not in Config.xml.
           Please add the consent to Config.xml or delete columns and data from 'participant_status'"
        );
    }
}
// Check participant_status columns and data for each consent in Config.xml
foreach ($consentList as $consentName=>$consentLabel) {
    $consentDate       = $consentName . "_date";
    $consentWithdrawal = $consentName . "_withdrawal";
    $statusExists      = $db->columnExists('participant_status', $consentName);
    $dateExists        = $db->columnExists('participant_status', $consentDate);
    $withdrawalExists  = $db->columnExists('participant_status', $consentWithdrawal);
    // Check that no column is missing
    if (!($statusExists && $dateExists && $withdrawalExists)) {
        array_push($errors, "At least one column is missing for " . $consentName . " in participant_status table.
           Check that status, date, and withdrawal columns exist for this consent type.");
        print_r($errors);
        echo "\nResolve errors and run script again.\n";
        die();
    }
    // Check data
    $dataQuery = "SELECT ID, CandID, " . $db->escape($consentName) . ", " . $db->escape($consentDate) . ", " .
                 $db->escape($consentWithdrawal) . " FROM participant_status";
    $psData    = $db->pselect($dataQuery, array());
    foreach ($psData as $entry) {
        $status     = $entry[$consentName];
        $date       = $entry[$consentDate];
        $withdrawal = $entry[$consentWithdrawal];
        $consentID  = $entry['ID'];
        $candID     = $entry['CandID'];
        // Check if consent status is not_answered
        if($status === "not_answered") {
            array_push($errors, "Deprecated consent status 'not_answered' found for " . $consentName . ":
                       [ID]     => " . $consentID . "
                       [CandID] => " . $candID . "
                       Please change to a valid status or remove data.");
        }
        // Check if consent status is null or empty but there are dates
        if(empty($status) && (!empty($date) || !empty($withdrawal))) {
            array_push($errors, "Consent status not found for " . $consentName . ":
                       [ID]     => " . $consentID . "
                       [CandID] => " . $candID . " where there are dates.");
        }
        // Check if consent status is yes but consent date is empty
        if($status === "yes" && empty($date)) {
            array_push($errors, "The date of consent is missing for " . $consentName . ":
                       [ID]     => " . $consentID . "
                       [CandID] => " . $candID . "
                       All 'yes' statuses must have a consent date.");
        }
        // Check if consent status is no and consent date given, but withdrawal date is empty
        if($status === "no" && !empty($date)) {
            if(empty($withdrawal)) {
                array_push($errors, "The date of withdrawal is missing for " . $consentName . ":
                           [ID]     => " . $consentID . "
                           [CandID] => " . $candID . "
                           All 'no' statuses with given consent date must have a withdrawal date.");
            }
        }
        // Check for zero dates
        if($date === "0000-00-00" || $withdrawal === "0000-00-00") {
            array_push($errors, "Zero dates found in participant_status for " . $consentName . ":
                       [ID]     => " . $consentID . "
                       [CandID] => " . $candID . "
                       Please remove date or run /tools/DB_date_zeros_removal.php.");
        }
    }
}
////////////////////////////////////////////////
// CHECK NEW TABLES AND CONFIG SETTINGS EXIST //
////////////////////////////////////////////////

// Check useConsent was inserted into ConfigSettings
$configID    = $db->pselectOne("SELECT ID FROM ConfigSettings WHERE Name='useConsent'", array());
if (empty($configID)) {
    array_push($errors, "useConsent missing from ConfigSettings table.
               Run SQL/New_patches/2018-03-01_normalise_consent.sql");
    print_r($errors);
    echo "\nResolve errors and run script again.\n";
    die();
}

$configValue = $db->pselectOne("SELECT Value FROM Config WHERE ConfigID=:configid",
                   array('configid'=>$configID));
if (empty($configValue)) {
    array_push($errors, "useConsent's Config value missing from Config table.
               Run SQL/New_patches/2018-03-01_normalise_consent.sql");
}
if (!$db->tableExists('consent') || !$db->tableExists('candidate_consent_rel') || !$db->tableExists('candidate_consent_history')) {
    array_push($errors, "New, normalized consent tables do not exist.
               Run SQL/New_patches/2018-03-01_normalise_consent.sql");
}
//////////////////
// THROW ERRORS //
//////////////////
if (!empty($errors)) {
    print_r($errors);
    echo "\nResolve errors and run script again.\n";
    die();
}
echo "\nValidation successful.\n";
/////////////////////
// CONTINUE SCRIPT //
/////////////////////

// Update ConfigSetting table with value of 'useConsent' if true. Default is set to false.
if (($useConsent === "true" || $useConsent == 1) && $configValue !== "true") {
    $updateValue = ['Value' => $useConsent];
    $db->update(
        'Config',
        $updateValue,
        array(
         'ConfigID' => $configID, 
        )
    );
    echo "\nConfig settings set to use consent.\n\n";
}
/////////////////////////////////////////////
// START IMPORT OF CONSENT INTO NEW TABLES //
/////////////////////////////////////////////

$dataArray  = [];
foreach ($consentList as $consentName=>$consentLabel) {
    // Populate consent table with consents from Config.xml

    // If consent doesn't already exist in `consent` table, insert
    $exists = $db->pselectOne(
        "SELECT * FROM consent WHERE Name=:consentname",
        array('consentname' => $consentName)
    );
    if (empty($exists)) {
        $db->insert(
            'consent',
            array(
               'Name'  => $consentName,
               'Label' => $consentLabel,
             )
        );
    }
    // Save ConsentID inserted
    $consentID = $db->pselectOne(
        "SELECT ConsentID FROM consent WHERE Name=:consentName",
        array('consentName' => $consentName)
    );
    // Get all data where consent status has a value in participant_status
    // Consent status without value means the candidate does not have this specific study consent
    $consentDate       = $consentName . "_date";
    $consentWithdrawal = $consentName . "_withdrawal";
    $dataQuery         = "SELECT CandID, " . $db->escape($consentName) . ", " . $db->escape($consentDate) . ", " . $db->escape($consentWithdrawal) . " FROM participant_status 
                         WHERE " . $db->escape($consentName) . " IS NOT NULL OR " . $db->escape($consentName) . " <> ''";
    $psData            = $db->pselect($dataQuery, array());
    foreach ($psData as $entry) {
        // Format data
        $consentValues = [
            'CandidateID'   => $entry['CandID'],
            'ConsentID'     => $consentID,
            'Status'        => $entry[$consentName],
            'DateGiven'     => $entry[$consentDate],
            'DateWithdrawn' => $entry[$consentWithdrawal],
        ];
        // Push each formatted entry to array
        array_push($dataArray, $consentValues);
    }
}
// Output list of data to be inserted into new table
echo "\nRows to be inserted into 'candidate_consent_rel' table ..\n";
echo "Empty dates will be inserted as NULL.\n\n";
print_r($dataArray);

// Populate candidate_consent_rel
foreach ($dataArray as $consentValues) {
    $db->insert('candidate_consent_rel', $consentValues);
}
echo "\nConsent data insert complete.\n";

// Select consent history and import into new history table
$historyFieldsQuery = "SELECT CandID, entry_staff, data_entry_date";

foreach ($consentList as $consentName=>$consentLabel) {
    $consentDate             = $consentName . "_date";
    $consentWithdrawal       = $consentName . "_withdrawal";
    $statusHistoryExists     = $db->columnExists('consent_info_history', $consentName);
    $dateHistoryExists       = $db->columnExists('consent_info_history', $consentDate);
    $withdrawalHistoryExists = $db->columnExists('consent_info_history', $consentWithdrawal);
    // As long as consent has columns in history table, import data
    if ($statusHistoryExists && $dateHistoryExists && $withdrawalHistoryExists) {
        $historyFieldsQuery .= ", " . $db->escape($consentName) . ", " . $db->escape($consentDate) . ", " . $db->escape($consentWithdrawal);
    }
}
$historyFieldsQuery .= " FROM consent_info_history";
$consentHistory = $db->pselect($historyFieldsQuery, array());

foreach ($consentHistory as $entry) {
    $candID = $entry['CandID'];
    $pscid = $db->pselectOne(
        "SELECT PSCID FROM candidate WHERE CandID=:cid",
        array('cid' => $candID)
    );
    $entryStaff = $entry['entry_staff'];
    $entryDate = $entry['data_entry_date'];

    foreach($consentList as $consentName=>$consentLabel) {
        if(array_key_exists($consentName, $entry)) {
            $consentStatus = $entry[$consentName];
            $consentDate = $entry[$consentName . '_date'];
            $consentWithdrawal = $entry[$consentName . '_withdrawal'];
            // import deprecated "not_answered" status as NULL
            if ($consentStatus === "not_answered") {
                $consentStatus = NULL;
            }
            // As long as there's some data in the history
            if(!empty($consentStatus) || !empty($consentDate) || !empty($consentWithdrawal)) {
                $formattedHistory = [
                'PSCID'         => $pscid,
                'ConsentName'   => $consentName,
                'ConsentLabel'  => $consentLabel,
                'Status'        => $consentStatus,
                'DateGiven'     => $consentDate,
                'DateWithdrawn' => $consentWithdrawal,
                'EntryStaff'    => $entryStaff,
                'EntryDate'     => $entryDate,
                ];
                //Populate candidate_consent_history table
                $db->insert('candidate_consent_history', $formattedHistory);
            }
        }
    }
}
echo "\nHistory data insert complete.\n";

///////////////////////////////////////////////////////////
// CREATE SQL FILE TO DROP DEPRECATED TABLES AND COLUMNS //
///////////////////////////////////////////////////////////

$output = "DROP TABLE consent_info_history;\n";
foreach ($existingColumns as $column) {
    $columnName = $column['Column_name'];
    $output .= "ALTER TABLE participant_status DROP COLUMN " . $columnName . ";\n";
}
$filename = __DIR__ . "/../../SQL/Cleanup_patches/delete_old_consent_tables.sql";
$fp       = fopen($filename, "w");
fwrite($fp, $output);
fclose($fp);
?>
