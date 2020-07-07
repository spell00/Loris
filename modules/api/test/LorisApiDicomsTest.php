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
class LorisApiDicomsTest extends LorisApiAuthenticationTest
{
    protected $candidTest    = "400162";
    protected $visitTest     = "V6";
    protected $tarfileTest   = "DCM_2016-08-15_ImagingUpload-18-25-i9GRv3.tar";
    protected $processidTest = "";

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicoms(): void
    {
        $$this->setUp();
        $response = $this->client->request(
            'GET',
            "candidates/$this->candidTest/$this->visitTest/dicoms",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
        $DicomArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );

        $this->assertArrayHasKey('Meta', $DicomArray);
        $this->assertArrayHasKey('CandID', $DicomArray['Meta']);
        $this->assertArrayHasKey('Visit', $DicomArray['Meta']);

        $this->assertArrayHasKey(
            'DicomTars',
            $DicomArray
        );
        $this->assertArrayHasKey(
            '0',
            $DicomArray['DicomTars']
        );
        $this->assertArrayHasKey(
            'Tarname',
            $DicomArray['DicomTars']['0']
        );

        $this->assertArrayHasKey(
            'SeriesInfo',
            $DicomArray['DicomTars']['0']
        );
        $this->assertArrayHasKey(
            '0',
            $DicomArray['DicomTars']['0']['SeriesInfo']
        );
        $this->assertArrayHasKey(
            'SeriesDescription',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'SeriesDescription',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'SeriesNumber',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'EchoTime',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'RepetitionTime',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'InversionTime',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'SliceThickness',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'Modality',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );
        $this->assertArrayHasKey(
            'SeriesUID',
            $DicomArray['DicomTars']['0']['SeriesInfo']['0']
        );

        $this->assertSame(gettype($DicomArray), 'array');
        $this->assertSame(gettype($DicomArray['Meta']), 'array');
        $this->assertSame(
            gettype($DicomArray['Meta']['CandID']),
            'string'
        );
        $this->assertSame(
            gettype($DicomArray['Meta']['Visit']),
            'string'
        );
        $this->assertSame(
            gettype($DicomArray['DicomTars']),
            'array'
        );
        $this->assertSame(
            gettype($DicomArray['DicomTars']['0']),
            'array'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']
            ),
            'array'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']
            ),
            'array'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['SeriesDescription']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['SeriesNumber']
            ),
            'integer'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['EchoTime']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['RepetitionTime']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['InversionTime']
            ),
            'NULL'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['1']['InversionTime']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['SliceThickness']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['Modality']
            ),
            'string'
        );
        $this->assertSame(
            gettype(
                $DicomArray['DicomTars']['0']['SeriesInfo']['0']['SeriesUID']
            ),
            'string'
        );

    }

    /**
     * Tests the HTTP POST request for the
     * endpoint /candidates/{candid}/{visit}/dicoms
     * // TODO HANDLING OF POST HANDLING NOT IMPLEMENTED
     *
     * @return void
     */
    public function testPostCandidatesCandidVisitDicoms(): void
    {
        $$this->setUp();
        try{
            $response = $this->client->request(
                'POST',
                "candidates/$this->candidTest/$this->visitTest/dicoms",
                [
                    'headers' => $this->headers,
                    'json'    => []
                ]
            );
            // Verify the status code
            $this->assertEquals(201, $response->getStatusCode());
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms/tarname
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsTarname(): void
    {
        $$this->setUp();
        $response = $this->client->request(
            'GET',
            "candidates/$this->candidTest/$this->visitTest/" .
            "dicoms/$this->tarfileTest",
            [
                'headers' => $this->headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);

        $resource        = fopen($this->tarfileTest, 'w');
        $stream          = GuzzleHttp\Psr7\stream_for($resource);
        $response_stream = $this->client->request(
            'GET',
            "candidates/$this->candidTest/$this->visitTest/dicoms/" .
            "$this->tarfileTest",
            [
                'headers' => $this->headers,
                'save_to' => $stream
            ]
        );
        $this->assertEquals(200, $response_stream->getStatusCode());
        // Verify the endpoint has a body
        $body = $response_stream->getBody();
        $this->assertNotEmpty($body);

        $this->assertFileIsReadable($this->tarfileTest);

    }

    // THESE ENDPOINTS DO NOT EXIST YET

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms/{tarname}/processes
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsTarnameProcesses(): void
    {
        $$this->setUp();
        try {
            $response = $this->client->request(
                'GET',
                "candidates/$this->candidTest/$this->visitTest/dicoms/" .
                "$this->tarfileTest/processes",
                [
                    'headers' => $this->headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms/{tarname}/processes/{processid}
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsTarnameProcessesProcessid():
    void
    {
        $$this->setUp();
        try{
            $response = $this->client->request(
                'GET',
                "candidates/$this->candidTest/$this->visitTest/dicoms/" .
                "$this->tarfileTest/processes/$this->processidTest",
                [
                    'headers' => $this->headers
                ]
            );
            $this->assertEquals(
                200,
                $response->getStatusCode()
            );
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}