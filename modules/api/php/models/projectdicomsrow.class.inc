<?php
/**
 * PHP Version 7
 *
 * @category API
 * @package  Loris
 * @author   Simon Pelletier <simon.pelletier@mcin.ca>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @link     https://www.github.com/aces/Loris/
 */

namespace LORIS\api\Models;

/**
 * A ProjectDicomsRow contains values from an image of a project.
 *
 * @category API
 * @package  Loris
 * @author   Simon Pelletier <simon.pelletier@mcin.ca>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @link     https://www.github.com/aces/Loris/
 */
class ProjectDicomsRow implements \LORIS\Data\DataInstance
{
    private $_candid;
    private $_pscid;
    private $_entitytype;
    private $_visitlabel;
    private $_visitdate;
    private $_centerid;
    private $_centername;
    private $_inserttime;
    private $_scantype;
    private $_tarname;
    private $_dicomarchiveid;
    private $_source;
    private $_archive;
    private $_processid;
    private $_acquisitionprotocolid;
    private $_tarchiveseriesid;
    private $_processprotocolid;
    /**
     * Create a new ProjectDicomsRow
     *
     * @param array $row An array of image propeties
     */
    public function __construct(array $row)
    {
        $this->_candid     = $row['Candidate'] ?? null;
        $this->_pscid      = $row['PSCID'] ?? null;
        $this->_entitytype = $row['Entity_type'] ?? null;
        $this->_visitlabel = $row['Visit'] ?? null;
        $this->_visitdate  = $row['Visit_date'] ?? null;
        $this->_centerid   = $row['CenterID'] ?? null;
        $this->_centername = $row['Site'] ?? null;
        $this->_tarname    = $row['tarchiveid'] ?? null;
        $this->_processid  = $row['processid'] ?? null;
        $this->_processprotocolid     = $row['ProcessProtocolID'] ?? null;
        $this->_tarchivesource        = $row['TarchiveSource'] ?? null;
        $this->_dicomarchiveid        = $row['DicomArchiveID'] ?? null;
        $this->_acquisitionprotocolid = $row['AcquisitionProtocolID'] ?? null;
        $this->_source           = $row['Source'] ?? null;
        $this->_archive          = $row['Archive'] ?? null;
        $this->_inserttime       = $row['InsertTime'] ?? null;
        $this->_scantype         = $row['ScanType'] ?? null;
        $this->_tarchiveseriesid = $row['TarchiveSeriesID'] ?? null;
    }

    /**
     * Implements \LORIS\Data\DataInstance interface for this row.
     *
     * @return string the row data.
     */
    public function toJSON() : string
    {
        $obj            = [
            'PSCID'                 => $this->_pscid,
            'AcquisitionProtocolID' => $this->_acquisitionprotocolid,
            'ProcessProtocolID'     => $this->_processprotocolid,
            'Candidate'             => $this->_candid,
            'Visit'                 => $this->_visitlabel,
            'Visit_date'            => $this->_visitdate,
            'Site'                  => $this->_centername,
            'InsertTime'            => $this->_inserttime,
            'TarchiveSource'        => $this->_tarchivesource,
            'TarchiveID'            => $this->_tarname,
            'processid'             => $this->_processid,
            'Source'                => $this->_source,
            'Archive'               => $this->_archive,
            'TarchiveSeriesID'      => $this->_tarchiveseriesid,
            'DicomArchiveID'        => $this->_dicomarchiveid
        ];
        $filename       = explode('/', $this->_archive)[1];
        $candid         = $obj['Candidate'];
        $visit          = $obj['Visit'];
        $obj['Tarname'] = $filename;
        $obj['Path']    = "/candidates/$candid/$visit/dicoms/$filename";
        $obj['InsertTime'] = date('c', (int) $obj['InsertTime']);

        return json_encode($obj);
    }

    /**
     * Returns the CenterID for this row, for filters such as
     * \LORIS\Data\Filters\UserSiteMatch to match again.
     *
     * @return integer The CenterID
     */
    public function getCenterID(): int
    {
        return intval($this->_centerid);
    }

    /**
     * This tells is the image is a phantom.
     *
     * @return bool True is the Entity_type is a scanner
     */
    public function isPhantom(): bool
    {
        return $this->_entitytype === 'Scanner';
    }
}
