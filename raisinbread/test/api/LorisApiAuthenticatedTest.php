<?php

require_once __DIR__ .
    "/../../../test/integrationtests/LorisIntegrationTest.class.inc";
use GuzzleHttp\Client;

/**
 * PHPUnit class for API test suite. This script sends HTTP requests to every
 * endpoints of the api module and look at the response content, status code and
 * headers where it applies. All endpoints are accessible at <host>/api/<version>/
 * (e.g. the endpoint of the version 0.0.3 of the API "/projects" URI for the host
 * "example.loris.ca" would be https://example.loris.ca/api/v0.0.3/projects)
 *
 * @category   API
 * @package    Tests
 * @subpackage Integration
 * @author     Simon Pelletier <simon.pelletier@mcin.ca>
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @link       https://www.github.com/aces/Loris/
 */
class LorisApiAuthenticatedTest extends LorisIntegrationTest
{

    protected $client;
    protected $headers;
    protected $base_uri;
    protected $originalJwtKey;
    protected $configIdJwt;
 
    /**
     * Call to LorisApiAuthenticationTest::setUp()
     *
     * @return void
     */
    public function setUp()
    {
        // Set up database wrapper and config
        $this->factory = NDB_Factory::singleton();
        $this->factory->reset();
        $this->factory->setTesting(false);

        $this->config = $this->factory->Config(CONFIG_XML);

        $database = $this->config->getSetting('database');

        $this->DB  = Database::singleton(
            $database['database'],
            $database['username'],
            $database['password'],
            $database['host'],
            1
        );

        // store the original JWT key for restoring it later
	$JwtConfig = $this->DB->pselect(
            '
            SELECT
              Value, ConfigID
            FROM
              Config
            WHERE
              ConfigID=
            (SELECT ID FROM ConfigSettings WHERE Name="JWTKey")',
            []
        )[0];

        $this->originalJwtKey = $JwtConfig['Value'];
        $this->configIdJwt    = $JwtConfig['ConfigID'];

        // generating a random JWTkey
        $new_id = bin2hex(random_bytes(30)) . 'A1!';

        $set = [
            'Value' => $new_id
        ];

        $where = [
            'ConfigID' => $this->configIdJwt
        ];

        $this->DB->update('Config', $set, $where);

        parent::setUp();

        $this->login('UnitTester', $this->validPassword);
    }

    /**
     * Used to log in with GuzzleHttp\Client
     *
     * @param string $username The username to log in as
     * @param string $password The (plain text) password to login as.
     *
     * @return void
     */
    public function login($username, $password)
    {
        $this->base_uri = "$this->url/api/v0.0.3/";
        $this->client   = new Client(['base_uri' => $this->base_uri]);
        $response       = $this->client->request(
            'POST',
            "login",
            [
                'json' => ['username' => $username,
                    'password' => $password
                ]
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $token = json_decode(
            $response->getBody()->getContents()
        )->token ?? null;

        if ($token === null) {
            throw new \LorisException("Login failed");
        }
        $headers       = [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json'
        ];
        $this->headers = $headers;
    }

    /**
     * Used to test login
     *
     * @return void
     */
    function testLoginSuccess()
    {
        $this->assertArrayHasKey('Authorization', $this->headers);
        $this->assertArrayHasKey('Accept', $this->headers);
    }

    /**
     * Call to LorisApiAuthenticationTest::tearDown()
     *
     * @return void
     */
    public function tearDown()
    {
        $set = [
            'Value' => $this->originalJwtKey
        ];

        $where = [
            'ConfigID' => $this->configIdJwt
        ];

        $this->DB->update('Config', $set, $where);
        parent::tearDown();
    }

}

