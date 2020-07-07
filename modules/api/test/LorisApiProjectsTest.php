<?php

require_once __DIR__ . "/LorisApiAuthenticationTest.php";

/**
 * PHPUnit class for API test suite. This script sends HTTP request to every enpoints
 * of the api module and look at the response content, status code and headers where
 * it applies. All endpoints are accessible at <host>/api/<version>/
 * (e.g. the endpoint of the version 0.0.3 ofd the API "/projects" URI for the host
 * "example.loris.ca" would be https://example.loris.ca/api/v0.0.3/projects)
 *
 * @category   API
 * @package    Tests
 * @subpackage Integration
 * @author     Simon Pelletier <simon.pelletier@mcin.ca>
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @link       https://www.github.com/aces/Loris/
 */
class LorisApiProjectsTest extends LorisApiAuthenticationTest
{
    protected $projectIdTest = "Pumpernickel";
    protected $candidTest    = "115788";
    protected $visitTest     = "V1";
    /**
     * Tests the HTTP GET request for the endpoint /projects
     *
     * @return void
     */
    public function testGetProjects(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $projectsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Projects',
            $projectsArray
        );
        $this->assertArrayHasKey(
            'Pumpernickel',
            $projectsArray['Projects']
        );
        $this->assertArrayHasKey(
            'useEDC',
            $projectsArray['Projects']['Pumpernickel']
        );
        $this->assertArrayHasKey(
            'PSCID',
            $projectsArray['Projects']['Pumpernickel']
        );
        $this->assertArrayHasKey(
            'Type',
            $projectsArray['Projects']['Pumpernickel']['PSCID']
        );
        $this->assertArrayHasKey(
            'Regex',
            $projectsArray['Projects']['Pumpernickel']['PSCID']
        );

        $this->assertSame(
            gettype(
                $projectsArray['Projects']
            ),
            'array'
        );
        $this->assertSame(
            gettype(
                $projectsArray['Projects']['Pumpernickel']
            ),
            'array'
        );
        $this->assertSame(
            gettype(
                $projectsArray['Projects']['Pumpernickel']['useEDC']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $projectsArray['Projects']['Pumpernickel']['PSCID']
            ),
            'array'
        );
        $this->assertSame(
            gettype($projectsArray['Projects']['Pumpernickel']['PSCID']['Type']),
            'string'
        );
        $this->assertSame(
            gettype($projectsArray['Projects']['Pumpernickel']['PSCID']['Regex']),
            'string'
        );

    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}
     *
     * @return void
     */
    public function testGetProjectsProject(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects/$this->projectIdTest",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $projectsProjectArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Meta',
            $projectsProjectArray
        );
        $this->assertArrayHasKey(
            'Project',
            $projectsProjectArray['Meta']
        );
        $this->assertArrayHasKey(
            'Candidates',
            $projectsProjectArray
        );
        $this->assertArrayHasKey(
            '0',
            $projectsProjectArray['Candidates']
        );

        $this->assertSame(
            gettype($projectsProjectArray['Meta']),
            'array'
        );
        $this->assertSame(
            gettype($projectsProjectArray['Meta']['Project']),
            'string'
        );
        $this->assertSame(
            gettype($projectsProjectArray['Candidates']),
            'array'
        );
        $this->assertSame(
            gettype($projectsProjectArray['Candidates']['0']),
            'string'
        );

    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/candidates
     *
     * @return void
     */
    public function testGetProjectsProjectCandidates(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects/$this->projectIdTest/candidates",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $projectsProjectArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Meta',
            $projectsProjectArray
        );
        $this->assertArrayHasKey(
            'Project',
            $projectsProjectArray['Meta']
        );
        $this->assertArrayHasKey(
            'Candidates',
            $projectsProjectArray
        );

        $this->assertSame(
            gettype($projectsProjectArray['Meta']),
            'array'
        );
        $this->assertSame(
            gettype($projectsProjectArray['Meta']['Project']),
            'string'
        );
        $this->assertSame(
            gettype($projectsProjectArray['Candidates']),
            'array'
        );
        $this->assertSame(
            gettype($projectsProjectArray['Candidates']['0']),
            'string'
        );

    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/images
     *
     * @return void
     */
    public function testGetProjectsProjectImages(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects/$this->projectIdTest/images",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
        $projectsImagesArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Images',
            $projectsImagesArray
        );
        $this->assertArrayHasKey(
            '0',
            $projectsImagesArray['Images']
        );
        $this->assertArrayHasKey(
            'Candidate',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'PSCID',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'Visit',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'Visit_date',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'Site',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'InsertTime',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'ScanType',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'QC_status',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'Selected',
            $projectsImagesArray['Images']['0']
        );
        $this->assertArrayHasKey(
            'Link',
            $projectsImagesArray['Images']['0']
        );

        $this->assertSame(
            gettype($projectsImagesArray['Images']),
            'array'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']),
            'array'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['Candidate']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['PSCID']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['Visit']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['Visit_date']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['Site']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['InsertTime']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['ScanType']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['QC_status']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['Selected']),
            'string'
        );
        $this->assertSame(
            gettype($projectsImagesArray['Images']['0']['Link']),
            'string'
        );
    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/visits
     *
     * @return void
     */
    public function testGetProjectsProjectVisits(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects/$this->projectIdTest/visits",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $projectsVisitsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Meta',
            $projectsVisitsArray
        );
        $this->assertArrayHasKey(
            'Project',
            $projectsVisitsArray['Meta']
        );
        $this->assertArrayHasKey(
            'Visits',
            $projectsVisitsArray
        );
        $this->assertArrayHasKey(
            '0',
            $projectsVisitsArray['Visits']
        );

        $this->assertSame(
            gettype($projectsVisitsArray['Meta']),
            'array'
        );
        $this->assertSame(
            gettype($projectsVisitsArray['Meta']['Project']),
            'string'
        );
        $this->assertSame(
            gettype($projectsVisitsArray['Visits']),
            'array'
        );
        $this->assertSame(
            gettype($projectsVisitsArray['Visits']['0']),
            'string'
        );

    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/instruments
     *
     * @return void
     */
    public function testGetProjectsProjectInstruments(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects/$this->projectIdTest/instruments",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $projectsInstrArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Meta',
            $projectsInstrArray
        );
        $this->assertArrayHasKey(
            'Project',
            $projectsInstrArray['Meta']
        );
        $this->assertArrayHasKey(
            'Instruments',
            $projectsInstrArray
        );
        $this->assertArrayHasKey(
            'radiology_review',
            $projectsInstrArray['Instruments']
        );
        $this->assertArrayHasKey(
            'bmi',
            $projectsInstrArray['Instruments']
        );
        $this->assertArrayHasKey(
            'medical_history',
            $projectsInstrArray['Instruments']
        );
        $this->assertArrayHasKey(
            'aosi',
            $projectsInstrArray['Instruments']
        );
        $this->assertArrayHasKey(
            'mri_parameter_form',
            $projectsInstrArray['Instruments']
        );

        $this->assertSame(
            gettype($projectsInstrArray['Meta']),
            'array'
        );
        $this->assertSame(
            gettype($projectsInstrArray['Meta']['Project']),
            'string'
        );
        $this->assertSame(
            gettype($projectsInstrArray['Instruments']),
            'array'
        );
        $this->assertSame(
            gettype($projectsInstrArray['Instruments']['aosi']),
            'array'
        );
        $this->assertSame(
            gettype(
                $projectsInstrArray['Instruments']['aosi']['Fullname']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $projectsInstrArray['Instruments']['aosi']['Subgroup']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $projectsInstrArray['Instruments']['aosi']['DoubleDataEntryEnabled']
            ),
            'boolean'
        );

    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @return void
     */
    public function testGetProjectsProjectInstrumentsInstrument(): void
    {
        $this->setUp();
        $response = $this->client->request(
            'GET',
            "projects/$this->projectIdTest/instruments/aosi",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $projectsInstrumentsAosiArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey(
            'Meta',
            $projectsInstrumentsAosiArray
        );
        $this->assertArrayHasKey(
            'InstrumentVersion',
            $projectsInstrumentsAosiArray['Meta']
        );
        $this->assertArrayHasKey(
            'InstrumentFormatVersion',
            $projectsInstrumentsAosiArray['Meta']
        );
        $this->assertArrayHasKey(
            'ShortName',
            $projectsInstrumentsAosiArray['Meta']
        );
        $this->assertArrayHasKey(
            'LongName',
            $projectsInstrumentsAosiArray['Meta']
        );
        $this->assertArrayHasKey(
            'IncludeMetaDataFields',
            $projectsInstrumentsAosiArray['Meta']
        );

        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Meta']),
            'array'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Meta']['InstrumentVersion']),
            'string'
        );
        $this->assertSame(
            gettype(
                $projectsInstrumentsAosiArray['Meta']['InstrumentFormatVersion']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $projectsInstrumentsAosiArray['Meta']['ShortName']
            ),
            'string'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Meta']['LongName']),
            'string'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Meta']['IncludeMetaDataFields']),
            'string'
        );

        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Elements']),
            'array'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Elements']['0']),
            'array'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Elements']['0']['Type']),
            'string'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Elements']['0']['GroupType']),
            'string'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Elements']['0']['Elements']),
            'array'
        );
        $this->assertSame(
            gettype($projectsInstrumentsAosiArray['Elements']['0']['Description']),
            'string'
        );

    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @return void

    public function testPatchProjectsProjectInstrumentsInstrument(): void
    {
        $this->setUp();
        $json     = [
            'Meta' => [
                'InstrumentVersion'  => '11',
                'InstrumentFormatVersion'   => "v0.0.1a-dev",
                'ShortName'    => "aosi",
                'LongName'    => "AOSI",
                'IncludeMetaDataFields' => "true"
            ],
            "Elements" => [
                "0" => [
                    'Type' => "ElementGroup",
                    'GroupType' => "Page",
                    'Elements' => [],
                    'Description' => "Item Re-Adminstration",
                ],
            ]

        ];

        $response = $this->client->request(
            'PATCH',
            "projects/$this->projectIdTest/instruments/aosi",
            [
                'headers' => $this->headers,
                'json' => $json
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }
     */
}