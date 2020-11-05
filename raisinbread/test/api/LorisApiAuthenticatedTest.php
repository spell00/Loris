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
    protected $version;
    protected $headers;
    protected $base_uri;
    protected $originalJwtKey;
    protected $configIdJwt;
 
    /**
     * Overrides LorisIntegrationTest::setUp() to store the current JWT key
     * and replaces it for an acceptable one.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->_version = 'v0.0.4-dev';

        // store the original JWT key for restoring it later
        $jwtConfig = $this->DB->pselect(
            '
            SELECT
              Value, ConfigID
            FROM
              Config
            WHERE
              ConfigID=
            (SELECT ID FROM ConfigSettings WHERE Name="JWTKey")
            ',
            []
        )[0] ?? null;

        if ($jwtConfig === null) {
            throw new \LorisException('There is no Config for "JWTKey"');
        }

        $this->originalJwtKey = $jwtConfig['Value'];
        $this->configIdJwt    = $jwtConfig['ConfigID'];

        // generating a random JWTkey
        $new_id = bin2hex(random_bytes(30)) . 'A1!';

        $set = [
            'Value' => $new_id
        ];

        $where = [
            'ConfigID' => $this->configIdJwt
        ];

        $this->DB->update('Config', $set, $where);

        $this->apiLogin('UnitTester', $this->validPassword);

<<<<<<< 88794fcc924c330f247d501907319f78f497dfc9

=======
>>>>>>> changing adding new candidate in authentication script
        $this->DB->insert(
            "candidate",
            [
                'CandID'                => '900000',
                'PSCID'                 => 'TST0001',
                'RegistrationCenterID'  => 1,
                'RegistrationProjectID' => 1,
                'Active'                => 'Y',
                'UserID'                => 1,
                'Entity_type'           => 'Human',
                'Sex'                   => 'Female'
            ]
        );
        $this->DB->insert(
            'session',
            [
                'ID'            => '999999',
                'CandID'        => '900000',
                'Visit_label'   => 'V1',
                'CenterID'      => 1,
                'ProjectID'     => 1,
                'Current_stage' => 'Not Started',
            ]
        );
        $this->DB->insert(
            'test_names',
            [
                'ID'        => '999999',
                'Test_name' => 'testtest',
                'Full_name' => 'Test Test',
                'Sub_group' => 1,
            ]
        );
        $this->DB->insert(
            'flag',
            [
                'ID'        => '999999',
                'SessionID' => '999999',
                'Test_name' => 'testtest',
                'CommentID' => '11111111111111111',
            ]
        );
        $this->DB->insert(
            'flag',
            [
                'ID'        => '999999',
                'SessionID' => '999999',
                'Test_name' => 'testtest',
                'CommentID' => 'DDE_11111111111111111',
            ]
        );
    }

    /**
     * Used to log in with GuzzleHttp\Client
     *
     * @param string $username The username to log in as
     * @param string $password The (plain text) password to login as.
     *
     * @return void
     */
    public function apiLogin($username, $password)
    {
        $this->base_uri = "$this->url/api/$this->_version/";
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
     * Overrides LorisIntegrationTest::tearDown() to set the original key back.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->DB->delete("session", ['CandID' => '900000']);
        $this->DB->delete("candidate", ['CandID' => '900000']);
        $this->DB->delete("flag", ['ID' => '999999']);
        $this->DB->delete("test_names", ['ID' => '999999']);

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

