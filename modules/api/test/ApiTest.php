<?php

require_once __DIR__ .
    "/../../../test/integrationtests/LorisIntegrationTest.class.inc";
use GuzzleHttp\Client;

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
class LorisApiTests extends LorisIntegrationTest
{

    private $_client;
    private $_headers;
    private $_base_uri;

    /**
     * Used to log in with GuzzleHttp\Client
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function _guzzleLogin()
    {
        // $this->base_uri = "$this->url/api/v0.0.3/";
        $this->_base_uri = "$this->url/api/v0.0.3/";
        $this->_client   = new Client(['base_uri' => $this->_base_uri]);
        $response        = $this->_client->request(
            'POST',
            "$this->_base_uri/login",
            [
                'json' => ['username' => "UnitTester",
                    'password' => $this->validPassword
                ]
            ]
        );
        $token           = json_decode(
            $response->getBody()->getContents()
        )->token ?? null;
        $headers         = [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json'
        ];
        $this->_headers  = $headers;
    }

    // PROJECTS

    /**
     * Tests the HTTP GET request for the endpoint /projects
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjects(): void
    {
        $this->_guzzleLogin();
        $response = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjectsProject(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $projectIds   = array_keys($candidsArray['Projects']);
        foreach ($projectIds as $projectId) {
            $response = $this->_client->request(
                'GET',
                "$this->_base_uri/projects/$projectId",
                [
                    'headers' => $this->_headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/candidates
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjectsProjectCandidates(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $projectIds   = array_keys($candidsArray['Projects']);
        foreach ($projectIds as $projectId) {
            $response = $this->_client->request(
                'GET',
                "$this->_base_uri/projects/$projectId/candidates",
                [
                    'headers' => $this->_headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/images
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjectsProjectImages(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $projectIds   = array_keys($candidsArray['Projects']);
        foreach ($projectIds as $projectId) {
            $response = $this->_client->request(
                'GET',
                "$this->_base_uri/projects/$projectId/images",
                [
                    'headers' => $this->_headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/visits
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjectsProjectVisits(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $projectIds   = array_keys($candidsArray['Projects']);
        foreach ($projectIds as $projectId) {
            $response = $this->_client->request(
                'GET',
                "$this->_base_uri/projects/$projectId/visits",
                [
                    'headers' => $this->_headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests the HTTP GET request for the endpoint /projects/{project}/instruments
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjectsProjectInstruments(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $projectIds   = array_keys($candidsArray['Projects']);
        foreach ($projectIds as $projectId) {
            $response = $this->_client->request(
                'GET',
                "$this->_base_uri/projects/$projectId/instruments",
                [
                    'headers' => $this->_headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetProjectsProjectInstrumentsInstrument(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/projects",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $projectIds   = array_keys($candidsArray['Projects']);
        foreach ($projectIds as $projectId) {
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/projects/$projectId/instruments",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $instruments = array_keys($visitsArray['Instruments']);
            foreach ($instruments as $instrument) {
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/projects/$projectId/instruments/$instrument",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPatchProjectsProjectInstrumentsInstrument(): void
    {
        $this->_guzzleLogin();
        $response = $this->_client->request(
            'PATCH',
            'https://spelletier-dev.loris.ca
            /api/v0.0.3//candidates/300001/V1/instruments/aosi',
            [
                'headers' => $this->_headers,
                'json'    => []
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    // CANDIDATES

    /**
     * Tests the HTTP GET request for the endpoint /candidates
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidates(): void
    {
        $this->_guzzleLogin();
        $response = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        // Verify the endpoint has a header
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * Tests the HTTP GET request for the endpoint /candidates/{candid}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandid(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id       = $candidsArray['Candidates'][$candid]['CandID'];
            $response = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests the HTTP POST request for the endpoint /candidates/{candid}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPostCandidatesCandid(): void
    {
        $this->_guzzleLogin();
        $json1      = [
            'Candidate' =>
                [
                    'Project' => "Rye",
                    'Site'    => "Data Coordinating Center",
                    'EDC'     => "2020-01-03",
                    'DoB'     => "2020-01-03",
                    'Sex'     => "Male"
                ]
        ];
        $json_exist = [
            'Candidate' =>
                [
                    'Project' => "Pumpernickel",
                    'Site'    => "Data Coordinating Center",
                    'EDC'     => "2020-01-01",
                    'DoB'     => "2020-01-01",
                    'Sex'     => "Female"
                ]
        ];
        $jsons      = [$json1, $json_exist];
        foreach ($jsons as $json) {
            $response = $this->_client->request(
                'POST',
                "$this->_base_uri/candidates",
                [
                    'headers' => $this->_headers,
                    'json'    => $json
                ]
            );
            // Verify the status code
            $this->assertEquals(201, $response->getStatusCode());
            // Verify the endpoint has a header
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]);
            }
            // Verify the endpoint has a body
            $body = $response->getBody();
            $this->assertNotEmpty($body);
        }
    }

    // VISITS

    /**
     * Tests the HTTP GET request for the endpoint /candidates/{candid}/{visit}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisit(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP PUT request for the endpoint /candidates/{candid}/{visit}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPutCandidatesCandidVisit(): void
    {
        $this->_guzzleLogin();
        $candid   = '115788';
        $visit    = 'V2';
        $json     = ['CandID'  => $candid,
            'Visit'   => $visit,
            'Site'    => "Data Coordinating Center",
            'Battery' => "Fresh",
            'Project' => "Pumpernickel"
        ];
        $response = $this->_client->request(
            'PUT',
            "$this->_base_uri/candidates/$candid/$visit",
            [
                'headers' => $this->_headers,
                'json'    => $json
            ]
        );
        // Verify the status code
        $this->assertEquals(201, $response->getStatusCode());
        // Verify the endpoint has a header
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
        $response = $this->_client->request(
            'PUT',
            "$this->_base_uri/candidates/$candid/$visit",
            [
                'headers' => $this->_headers,
                'json'    => $json
            ]
        );
        // Verify the status code; should be 204 because it was just created,
        // so it already exists
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/imaging/qc
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitQcImaging(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/qc/imaging",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP PUT request for the
     * endpoint /candidates/{candid}/{visit}/imaging/qc
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPutCandidatesCandidVisitQcImaging(): void
    {
        $this->_guzzleLogin();
        $candid   = '300003';
        $visit    = 'V3';
        $json     = ['CandID'  => $candid,
            'Visit'   => $visit,
            'Site'    => "Montreal",
            'Battery' => "Fresh",
            'Project' => "Pumpernickel"
        ];
        $response = $this->_client->request(
            'PUT',
            "$this->_base_uri/candidates/$candid/$visit",
            [
                'headers' => $this->_headers,
                'json'    => $json
            ]
        );
        // Verify the status code
        $this->assertEquals(201, $response->getStatusCode());
        // Verify the endpoint has a header
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
        $response = $this->_client->request(
            'PUT',
            "$this->_base_uri/candidates/$candid/$visit",
            [
                'headers' => $this->_headers,
                'json'    => $json
            ]
        );
        // Verify the status code; should be 204 because it was just created,
        // so it already exists
        $this->assertEquals(204, $response->getStatusCode());
    }

    // INSTRUMENTS

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/instruments
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitInstruments(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/instruments/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/instruments/{instruments}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrument(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/instruments/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $instrumentsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $instruments      = array_keys($instrumentsArray['Instruments']);
                foreach ($instruments as $instrument) {
                    $instr    = $instrumentsArray['Instruments'][$instrument];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/instruments/$instr",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * TODO NOT WORKING: internal server error
     * Tests the HTTP PATCH request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPatchCandidatesCandidVisitInstrumentsInstrument(): void
    {
        $this->_guzzleLogin();
        $response = $this->_client->request(
            'PATCH',
            'https://spelletier-dev.loris.ca
            /api/v0.0.3/candidates/300001/V1/instruments/aosi',
            [
                'headers' => $this->_headers,
                'json'    => []
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * TODO NOT WORKING: internal server error
     * Tests the HTTP PUT request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @param string $candid candidate ID
     * @param string $visit  visit ID
     *
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPutCandidatesCandidVisitInstrumentsInstrument(
        $candid = '115788',
        $visit = 'V2'
    ): void {
        $this->_guzzleLogin();
        $json     = [
            'CandID'  => $candid,
            'Visit'   => $visit,
            'Site'    => "Data Coordinating Center",
            'Battery' => "Fresh",
            'Project' => "Pumpernickel"
        ];
        $response = $this->_client->request(
            'PUT',
            'https://spelletier-dev.loris.ca
            /api/v0.0.3//candidates/300001/V1/instruments/aosi',
            [
                'headers' => $this->_headers,
                'json'    =>
                    [
                        'candid' => $json
                    ]
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/instruments/{instruments}/flags
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentFlags(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/instruments/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $instrumentsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $instruments      = array_keys($instrumentsArray['Instruments']);
                foreach ($instruments as $instrument) {
                    $instr    = $instrumentsArray['Instruments'][$instrument];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/instruments/$instr/flags",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * TODO NOT WORKING: error 405 Not Allowed
     * Tests the HTTP PATCH request for the
     * endpoint /projects/{project}/instruments/{instrument}/flag
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPatchCandidatesCandidVisitInstrumentsInstrumentFlags(): void
    {
        $candid     = '300001';
        $visit      = 'V1';
        $instrument = 'aosi';
        $this->_guzzleLogin();
        $response = $this->_client->request(
            'PATCH',
            "https://spelletier-dev.loris.ca/api/v0.0.3/
            candidates/$candid/$visit/instruments/$instrument/flag",
            [
                'headers' => $this->_headers,
                'json'    => []
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * TODO NOT WORKING: Client error 405 not allowed
     * Tests the HTTP PUT request for the
     * endpoint /projects/{project}/instruments/{instrument}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPutCandidatesCandidVisitInstrumentsInstrumentFlags(): void
    {
        $candid = '300001';
        $visit  = 'V1';
        $this->_guzzleLogin();
        $json     = ['CandID'  => $candid,
            'Visit'   => $visit,
            'Site'    => "Data Coordinating Center",
            'Battery' => "Fresh",
            'Project' => "Pumpernickel"
        ];
        $response = $this->_client->request(
            'PUT',
            "https://spelletier-dev.loris.ca/api/v0.0.3
            /candidates/$candid/$visit/instruments/aosi/flags",
            [
                'headers' => $this->_headers,
                'json'    =>
                    [
                        'candid' => $json
                    ]
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/instruments/{instruments}/dde
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentDde(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/instruments/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $instrumentsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $instruments      = array_keys($instrumentsArray['Instruments']);
                foreach ($instruments as $instrument) {
                    $instr    = $instrumentsArray['Instruments'][$instrument];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/instruments/$instr/dde",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/instruments/{instruments}/dde/flags
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentDdeFlags():
    void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/instruments/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $instrumentsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $instruments      = array_keys($instrumentsArray['Instruments']);
                foreach ($instruments as $instrument) {
                    $instr    = $instrumentsArray['Instruments'][$instrument];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/instruments/$instr/dde/flags",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    // IMAGES

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImages(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilename(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $fname    = $imagesArray['Files'][$file]['Filename'];
                    $resource = fopen($fname, 'w');
                    $stream   = GuzzleHttp\Psr7\stream_for($resource);
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$fname",
                        [
                            'headers' => $this->_headers,
                            'save_to' => $stream
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Download an image with
     * endpoint /candidates/{candid}/{visit}/images/{filename}
     *
     * @param string $id    candidate ID
     * @param string $visit visit ID
     *
     * @return void
     */
    private function _downloadCandidatesCandidVisitImagesFilename(
        string $id = '115788',
        string $visit = 'V3'
    ): void {
        if (!file_exists('/images')) {
            mkdir('/images');
        }
        $tarname  = "demo_$id\_$visit\_t1_001.mnc";
        $resource = fopen("/images/$tarname", 'w');
        $stream   = GuzzleHttp\Psr7\stream_for($resource);
        $this->_client->request(
            'GET',
            "$this->_base_uri/$id/$visit/images/$tarname",
            [
                'headers' => $this->_headers,
                'save_to' => $stream
            ]
        );
    }

    /**
     * Download an image with endpoint /candidates/{candid}/{visit}/dicoms/{tarname}
     *
     * @param string $id    candidate ID
     * @param string $visit visit ID
     *
     * @return void
     */
    private function _downloadCandidatesCandidVisitDicomTarname(
        string $id = '115788',
        string $visit = 'V3'
    ): void {
        if (!file_exists('dicoms')) {
            mkdir('dicoms');
        }
        $tarName  = "DCM_2018-04-20_ImagingUpload-14-25-U1OlWq.tar";
        $resource = fopen("dicoms/$tarName", 'w');
        $stream   = GuzzleHttp\Psr7\stream_for($resource);
        $this->_client->request(
            'GET',
            "$this->_base_uri/candidates/$id/$visit/dicoms/$tarName",
            [
                'headers' => $this->_headers,
                'save_to' => $stream
            ]
        );
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/qc
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameQc(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $fname    = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$fname/qc",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP PUT request for the
     * endpoint /candidates/{candid}/{visit}/imaging/qc
     * TODO WILL RESULT IN ERROR; got the error
     * TODO "error":"Candidate from URL does not match JSON metadata."
     * Error in: /modules/api/php/endpoints/candidate/visit/image/qc.class.inc
     *
     * @param string $candid Candidate ID
     * @param string $visit  visit ID
     *
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPutCandidatesCandidVisitImagesFilenameQc(
        $candid = '115788',
        $visit = 'V3'
    ): void {
        $this->_guzzleLogin();
        $filename = 'demo_115788_V3_t2_001_t2-defaced_001.mnc';
        $json     = ['CandID'  => $candid,
            'Visit'   => $visit,
            'Site'    => "Data Coordinating Center",
            'Battery' => "Fresh",
            'Project' => "Pumpernickel"
        ];
        $response = $this->_client->request(
            'PUT',
            "$this->_base_uri/candidates/$candid/$visit/images/$filename/qc",
            [
                'headers' => $this->_headers,
                'json'    => $json
            ]
        );
        // Verify the status code
        $this->assertEquals(201, $response->getStatusCode());
        // Verify the endpoint has a header
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
        $response = $this->_client->request(
            'PUT',
            "$this->_base_uri/candidates/$candid/$visit",
            [
                'headers' => $this->_headers,
                'json'    => $json
            ]
        );
        // Verify the status code; should be 204 because it was just created,
        // so it already exists
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename/format/brainbrowser
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameFormatBbrowser(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $fname    = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$fname",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename/format/raw
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameFormatRaw(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $fname    = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$fname",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename/format/thumbnail
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameFormatThumbnail():
    void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $fname    = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$fname",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename/headers
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameHeaders(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $fname    = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$fname",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename/header/full
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameHeadersFull(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $imgFile  = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$imgFile",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/images/filename/header/headername
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitImagesFilenameHeadersHeadername():
    void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/images/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $imagesArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($imagesArray['Files']);
                foreach ($files as $file) {
                    $imgFile  = $imagesArray['Files'][$file]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/images/$imgFile",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    // DICOMS

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitDicoms(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/dicoms/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP POST request for the
     * endpoint /candidates/{candid}/{visit}/dicoms
     * // TODO HANDLING OF POST HANDLING NOT IMPLEMENTED
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPostCandidatesCandidVisitDicoms(): void
    {
        $this->_guzzleLogin();
        $candid   = '115788';
        $visit    = 'V2';
        $response = $this->_client->request(
            'POST',
            "$this->base_uricandidates/$candid/$visit/dicoms",
            [
                'headers' => $this->_headers,
                'json'    => $this->_headers
            ]
        );
        $this->assertEquals(201, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]);
        }
        // Verify the endpoint has a body
        $body = $response->getBody();
        $this->assertNotEmpty($body);
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms/tarname
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitDicomsTarname(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/dicoms",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $dicomsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($dicomsArray['DicomTars']);
                foreach ($files as $file) {
                    $tar      = $dicomsArray['DicomTars'][$file]['Tarname'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/recordings/$tar",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    // RECORDINGS

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordings(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]);
                }
                // Verify the endpoint has a body
                $body = $response->getBody();
                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdffile(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/recordings/$frecord",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}/channels
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdffileChannels(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/recordings/$frecord/channels",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}/channels/meta
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdffileChannelsMeta():
    void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/recordings/$frecord/channels/meta",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}/electrodes
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileElectrodes(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/recordings/$frecord/electrodes",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}/electrodes/meta
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileElectrodesMeta():
    void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/recordings/$frecord/electrodes/meta",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}/events
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileEvents(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode($response->getBody()->getContents()),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode($response->getBody()->getContents()),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode($response->getBody()->getContents()),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/recordings/$frecord/events/meta",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/recordings/{edffile}/events/meta
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileEventsMeta(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/recordings",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $recordFiles     = array_keys($recordingsArray['Files']);
                foreach ($recordFiles as $recordFile) {
                    $frecord  = $recordingsArray['Files'][$recordFile]['Filename'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri
                        /candidates/$id/$v/recordings/$frecord/events/meta",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    // ENDPOINTS IN THIS SECTION DOES NOT EXIST YET

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms/{tarname}/processes
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitDicomsTarnameProcesses(): void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v        = $visitsArray['Visits'][$visit];
                $response = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/dicoms",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $recordingsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files           = array_keys($recordingsArray['DicomTars']);
                foreach ($files as $file) {
                    $tar      = $recordingsArray['DicomTars'][$file]['Tarname'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/dicoms/$tar/processes",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]);
                    }
                    // Verify the endpoint has a body
                    $body = $response->getBody();
                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests the HTTP GET request for the
     * endpoint /candidates/{candid}/{visit}/dicoms/{tarname}/processes/{processid}
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCandidatesCandidVisitDicomsTarnameProcessesProcessid():
    void
    {
        $this->_guzzleLogin();
        $response     = $this->_client->request(
            'GET',
            "$this->_base_uri/candidates",
            [
                'headers' => $this->_headers
            ]
        );
        $candidsArray = json_decode(
            (string) utf8_encode(
                $response->getBody()->getContents()
            ),
            true
        );
        $candids      = array_keys($candidsArray['Candidates']);
        foreach ($candids as $candid) {
            $id          = $candidsArray['Candidates'][$candid]['CandID'];
            $response    = $this->_client->request(
                'GET',
                "$this->_base_uri/candidates/$id",
                [
                    'headers' => $this->_headers
                ]
            );
            $visitsArray = json_decode(
                (string) utf8_encode(
                    $response->getBody()->getContents()
                ),
                true
            );
            $visits      = array_keys($visitsArray['Visits']);
            foreach ($visits as $visit) {
                $v           = $visitsArray['Visits'][$visit];
                $response    = $this->_client->request(
                    'GET',
                    "$this->_base_uri/candidates/$id/$v/dicoms/",
                    [
                        'headers' => $this->_headers
                    ]
                );
                $dicomsArray = json_decode(
                    (string) utf8_encode(
                        $response->getBody()->getContents()
                    ),
                    true
                );
                $files       = array_keys($dicomsArray['DicomTars']);
                foreach ($files as $file) {
                    $tar      = $dicomsArray['DicomTars'][$file]['Tarname'];
                    $response = $this->_client->request(
                        'GET',
                        "$this->_base_uri/candidates/$id/$v/dicoms/$tar/processes",
                        [
                            'headers' => $this->_headers
                        ]
                    );
                    $processIdsArray = json_decode(
                        (string) utf8_encode(
                            $response->getBody()->getContents()
                        ),
                        true
                    );
                    $processIDs      = array_keys($processIdsArray['DicomTars']);
                    foreach ($processIDs as $processid) {
                        $response = $this->_client->request(
                            'GET',
                            "$this->_base_uri/
                            candidates/$id/$v/dicoms/$tar/processes/$processid",
                            [
                                'headers' => $this->_headers
                            ]
                        );
                        $this->assertEquals(
                            200,
                            $response->getStatusCode()
                        );
                        $headers = $response->getHeaders();
                        $this->assertNotEmpty($headers);
                        foreach ($headers as $header) {
                            $this->assertNotEmpty($header);
                            //$this->assertIsString($header[0]);
                        }
                        // Verify the endpoint has a body
                        $body = $response->getBody();
                        $this->assertNotEmpty($body);
                    }
                }
            }
        }
    }
}

// TODO Add method POST for /api/v0.0.3/projects/{project}/dicoms ,
// TODO Add endpoint GET /api/v0.0.3/projects/{project}/dicoms ,
// TODO Add endpoint POST /candidates/{candid}/{visit}/dicoms/{tarname}

