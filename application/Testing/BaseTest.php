<?php
//https://medium.com/helpspace/fresh-database-once-befor-testing-starts-faa2b10dc76f

namespace Application\Testing;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class BaseTest extends TestCase
{
    protected static $init = false;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        if (!self::$init) {
            TestingInitials::controlTestEnvironment();
            self::$init = true;
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub

        if (self::$init) {

        }
    }

    /**
     * Define custom actions here
     */
    private $login_data = <<<JSON
    {
        "email": "admin@gmail.com",
        "password": "secretss"
    }

    JSON;

    public $login_token = null;

    public function login($login_data = null)
    {
        if ($login_data) $data = $login_data;
        else $data = json_decode($this->login_data, true);

        $response = $this->post('/api/mobile/login', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $response_data = json_decode($response->getContent(), true);
        $this->login_token = $response_data['data']['token'];

        assertNotNull($this->login_token, 'Login Token is null');
    }

    public function sendAuthorizedRequest($url, $type, $data = [])
    {
        if ($this->login_token == null) $this->login();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->login_token
        ]);

        if ($type == 'POST') return $this->post($url, $data);
        else return $this->get($url);
    }

    public function sendNormalRequest($url, $type, $data = [])
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->login_token
        ]);

        if ($type == 'POST') return $this->post($url, $data);
        else return $this->get($url);
    }
}
