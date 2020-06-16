<?php
/**
 * PHPUnit class for API testsuite
 *
 * @category   API
 * @package    Tests
 * @subpackage Login
 * @author     Simon Pelletier <simon.pelletier@mcin.ca>
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @link       https://www.github.com/aces/Loris/
 */
require_once __DIR__ . "../../../test/LorisIntegrationTest.class.inc";
use GuzzleHttp\Client;


class ProjectsTest extends LorisIntegrationTest
{

    private $client;
    private $headers;
    private $base_uri;

    /**
     * Used to log in
     *
     * @return void
     */
    private function guzzleLogin()
    {
        $this->base_uri = $this->url . '/api/v0.0.3/';
        $this->client   = new Client(['base_uri' => $this->base_uri]);
        $response        = $this->client->request(
            'POST',
            $this->base_uri . '/login',
            ['json' => ['username' => UnitTester, 'password' => $this->validPassword]]
        );
        $token           = json_decode($response->getBody()->getContents())->token ?? null;
        $headers         = ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json',];
        $this->headers  = $headers;
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetProjectsProjectCandidatesEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/projects', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $keys = array_keys($json_arr['Projects']);
        foreach ($keys as $key) {
            $response    = $this->client->request(
                'GET',
                $this->base_uri . '/projects/' . $key . '/candidates',
                ['headers' => $this->headers]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]); # The method assertIsString is not found
            }

            // Verify the endpoint has a body
            $body = $response->getBody();

            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetProjectsProjectImagesEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/projects', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $keys = array_keys($json_arr['Projects']);
        foreach ($keys as $key) {
            $response    = $this->client->request(
                'GET',
                $this->base_uri . '/projects/' . $key . '/images',
                ['headers' => $this->headers]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]); # The method assertIsString is not found
            }

            // Verify the endpoint has a body
            $body = $response->getBody();

            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetProjectsProjectVisitsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/projects', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $keys = array_keys($json_arr['Projects']);
        foreach ($keys as $key) {
            $response    = $this->client->request(
                'GET',
                $this->base_uri . '/projects/' . $key . '/visits',
                ['headers' => $this->headers]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]); # The method assertIsString is not found
            }

            // Verify the endpoint has a body
            $body = $response->getBody();

            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetProjectsProjectInstrumentsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/projects', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $keys = array_keys($json_arr['Projects']);
        foreach ($keys as $key) {
            $response    = $this->client->request(
                'GET',
                $this->base_uri . '/projects/' . $key . '/instruments',
                ['headers' => $this->headers]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]); # The method assertIsString is not found
            }

            // Verify the endpoint has a body
            $body = $response->getBody();

            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetProjectsProjectInstrumentsInstrument(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/projects', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);
        $base_uri    = $this->base_uri;
        $keys = array_keys($json_arr['Projects']);
        foreach ($keys as $projectID) {
            $base_uri = $this->base_uri . '/projects/' . $projectID . '/instruments';
            $response = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr    = json_decode((string) utf8_encode($json_string), true);
            $instruments = array_keys($json_arr['Instruments']);
            foreach ($instruments as $instrument) {
                $response = $this->client->request(
                    'GET',
                    $base_uri . '/' . $instrument,
                    ['headers' => $this->headers]
                );
                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $this->assertEquals(200, $response->getStatusCode());

        // Verify the endpoint has a header
        $headers = $response->getHeaders();
        $this->assertNotEmpty($headers);
        foreach ($headers as $header) {
            $this->assertNotEmpty($header);
            //$this->assertIsString($header[0]); # The method assertIsString is not found
        }

        // Verify the endpoint has a body
        $body = $response->getBody();

        $this->assertNotEmpty($body);
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $keys = array_keys($json_arr['Candidates']);
        foreach ($keys as $key) {
            $a = $json_arr['Candidates'][$key]['CandID'];
            $response    = $this->client->request(
                'GET',
                $this->base_uri . '/candidates/' . $a,
                ['headers' => $this->headers]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $headers = $response->getHeaders();
            $this->assertNotEmpty($headers);
            foreach ($headers as $header) {
                $this->assertNotEmpty($header);
                //$this->assertIsString($header[0]); # The method assertIsString is not found
            }

            // Verify the endpoint has a body
            $body = $response->getBody();

            $this->assertNotEmpty($body);
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2    = json_decode((string) utf8_encode($json_string), true);
            $visits        = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $response    = $this->client->request(
                    'GET',
                    $base_uri . '/' . $json_arr2['Visits'][$visit],
                    ['headers' => $this->headers]
                );

                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitQcImagingEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2    = json_decode((string) utf8_encode($json_string), true);
            $visits        = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $response    = $this->client->request(
                    'GET',
                    $base_uri . '/' . $json_arr2['Visits'][$visit] . '/qc/imaging',
                    ['headers' => $this->headers]
                );

                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitInstrumentsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2    = json_decode((string) utf8_encode($json_string), true);
            $visits        = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $response    = $this->client->request(
                    'GET',
                    $base_uri . '/' . $json_arr2['Visits'][$visit] . '/instruments',
                    ['headers' => $this->headers]
                );

                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/instruments/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $instruments      = array_keys($json_arr3['Instruments']);
                foreach ($instruments as $instrument) {
                    try {
                        $a = $json_arr3['Instruments'][$instrument];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentFlagsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/instruments/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $instruments      = array_keys($json_arr3['Instruments']);
                foreach ($instruments as $instrument) {
                    try {
                        $a = $json_arr3['Instruments'][$instrument];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a . '/flags',
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentDdeEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/instruments/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $instruments      = array_keys($json_arr3['Instruments']);
                foreach ($instruments as $instrument) {
                    try {
                        $a = $json_arr3['Instruments'][$instrument];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a . '/dde',
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitInstrumentsInstrumentDdeFlagsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/instruments/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $instruments      = array_keys($json_arr3['Instruments']);
                foreach ($instruments as $instrument) {
                    try {
                        $a = $json_arr3['Instruments'][$instrument];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a . '/dde/flags',
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2    = json_decode((string) utf8_encode($json_string), true);
            $visits        = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $response    = $this->client->request(
                    'GET',
                    $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images',
                    ['headers' => $this->headers]
                );

                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameQcEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameFormatBrainbrowserEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameFormatRawEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameFormatThumbnailEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameHeadersEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameHeadersFullEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitImagesFilenameHeadersHeadernameEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/images/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['Files']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['Files'][$file]['Filename'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                        if ($a === 'mri_parameter_form') {
                            echo 'nothing';
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2    = json_decode((string) utf8_encode($json_string), true);
            $visits        = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $response    = $this->client->request(
                    'GET',
                    $base_uri . '/' . $json_arr2['Visits'][$visit] . '/dicoms',
                    ['headers' => $this->headers]
                );

                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsTarnameEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/dicoms/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['DicomTars']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['DicomTars'][$file]['Tarname'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a,
                            ['headers' => $this->headers]
                        );
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2    = json_decode((string) utf8_encode($json_string), true);
            $visits        = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );

                $this->assertEquals(200, $response->getStatusCode());
                $headers = $response->getHeaders();
                $this->assertNotEmpty($headers);
                foreach ($headers as $header) {
                    $this->assertNotEmpty($header);
                    //$this->assertIsString($header[0]); # The method assertIsString is not found
                }

                // Verify the endpoint has a body
                $body = $response->getBody();

                $this->assertNotEmpty($body);
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'],
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileChannelsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'] . '/channels',
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileChannelsMetaEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'] . '/channels/meta',
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileElectrodesEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'] . '/electrodes',
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileElectrodesMetaEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'] . '/electrodes/meta',
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileEventsEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'] . '/events',
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitRecordingsEdfFileEventsMetaEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/recordings';
                $response  = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $recordFiles = array_keys($json_arr3['Files']);
                foreach ($recordFiles as $recordFile) {
                    $response  = $this->client->request(
                        'GET',
                        $base_uri2 . '/' . $json_arr3['Files'][$recordFile]['Filename'] . '/events/meta',
                        ['headers' => $this->headers]
                    );

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
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
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsTarnameProcessesEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2 = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/dicoms/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files      = array_keys($json_arr3['DicomTars']);
                foreach ($files as $file) {
                    try {
                        $a = $json_arr3['DicomTars'][$file]['Tarname'];
                        $response = $this->client->request(
                            'GET',
                            $base_uri2 . '/' . $a . '/processes',
                            ['headers' => $this->headers]
                        );
                    } catch (\Exception $e) {
                        echo $e->getMessage(), "\n\n";
                    }

                    $this->assertEquals(200, $response->getStatusCode());
                    $headers = $response->getHeaders();
                    $this->assertNotEmpty($headers);
                    foreach ($headers as $header) {
                        $this->assertNotEmpty($header);
                        //$this->assertIsString($header[0]); # The method assertIsString is not found
                    }

                    // Verify the endpoint has a body
                    $body = $response->getBody();

                    $this->assertNotEmpty($body);
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testGetCandidatesCandidVisitDicomsTarnameProcessesProcessidEndpoint(): void
    {
        $this->guzzleLogin();
        $response    = $this->client->request('GET', $this->base_uri . '/candidates', ['headers' => $this->headers]);
        $json_string = $response->getBody()->getContents();
        $json_arr    = json_decode((string) utf8_encode($json_string), true);

        $candids = array_keys($json_arr['Candidates']);
        foreach ($candids as $candid) {
            $id = $json_arr['Candidates'][$candid]['CandID'];
            $base_uri    = $this->base_uri . '/candidates/' . $id;
            $response    = $this->client->request(
                'GET',
                $base_uri,
                ['headers' => $this->headers]
            );
            $json_string = $response->getBody()->getContents();
            $json_arr2   = json_decode((string) utf8_encode($json_string), true);
            $visits      = array_keys($json_arr2['Visits']);
            foreach ($visits as $visit) {
                $base_uri2   = $base_uri . '/' . $json_arr2['Visits'][$visit] . '/dicoms/';
                $response    = $this->client->request(
                    'GET',
                    $base_uri2,
                    ['headers' => $this->headers]
                );
                $json_string = $response->getBody()->getContents();
                $json_arr3   = json_decode((string) utf8_encode($json_string), true);
                $files       = array_keys($json_arr3['DicomTars']);
                foreach ($files as $file) {
                    $a = $json_arr3['DicomTars'][$file]['Tarname'];
                    $base_uri3   = $base_uri2 . '/' . $a . '/processes';
                    $response    = $this->client->request(
                        'GET',
                        $base_uri3,
                        ['headers' => $this->headers]
                    );
                    $json_string = $response->getBody()->getContents();
                    $json_arr4   = json_decode((string) utf8_encode($json_string), true);
                    $processIDs  = array_keys($json_arr4['DicomTars']);
                    foreach ($files as $file) {
                        $this->assertEquals(200, $response->getStatusCode());
                        $headers = $response->getHeaders();
                        $this->assertNotEmpty($headers);
                        foreach ($headers as $header) {
                            $this->assertNotEmpty($header);
                            //$this->assertIsString($header[0]); # The method assertIsString is not found
                        }

                        // Verify the endpoint has a body
                        $body = $response->getBody();

                        $this->assertNotEmpty($body);
                    }
                }
            }
        }
    }

    /**
     * Tests all POST endpoints for Projects
     *
     * @return void
     */
    public function testPostProjectsProjectCandidatesEndpoint(): void
    {
        $this->guzzleLogin();
        $json1       = [
            'Candidate' =>
                [
                    'CandID'  => "111111",
                    'Project' => "Rye",
                    'PSCID'   => "DCC355",
                    'Site'    => "Data Coordinating Center",
                    'EDC'     => "2020-01-03",
                    'DoB'     => "2020-01-03",
                    'Sex'     => "Male"
                ]
        ];
        $json_exist  = [
            'Candidate' =>
                [
                    'CandID'  => "115787",
                    'Project' => "Pumpernickel",
                    'PSCID'   => "DCC355",
                    'Site'    => "Data Coordinating Center",
                    'EDC'     => "2020-01-01",
                    'DoB'     => "2020-01-01",
                    'Sex'     => "Female"
                ]
        ];
        $jsons       = [$json1, $json_exist];
        foreach ($jsons as $json) {
            $response    = $this->client->request(
                'POST',
                $this->base_uri . '/candidates',
                ['headers' => $this->headers,'json' => $json]
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
}


// TODO Add endpoint /api/v0.0.3/projects/{project}/dicoms

// EDF (recordings) file at https://spelletier-dev.loris.ca/api/v0.0.3/candidates/300167/V1/recordings/sub-OTT167_ses-V1_task-faceO_eeg.edf
// image at https://spelletier-dev.loris.ca/api/v0.0.3/candidates/400162/V6/images/[demo_400162_V6_t1_001.mnc, demo_400162_V6_t2_001.mnc, demo_400162_V6_dwi25_001.mnc]
