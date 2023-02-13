<?php


namespace Application\Testing;


use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class BaseTest extends TestCase
{
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

    public function __construct() {
        parent::__construct();
        $this->controlTestEnvironment(true);
    }

    public function __destruct() {
        $this->controlTestEnvironment(false);
    }

    public function login()
    {
        $response = $this->post('/api/login', json_decode($this->login_data, true));
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $response_data = json_decode($response->getContent(), true);
        $this->login_token = $response_data['data']['token'];

        assertNotNull($this->login_token, 'Login Token is null');
    }

    public function sendAuthorizedRequest($url, $type, $data = [])
    {
        if ($this->login_token == null) $this->login();
        echo $this->login_token;

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

    public static function controlTestEnvironment($start = true) {
        $file = __DIR__ .'/../testing.json';
        $file_data = json_decode(file_get_contents($file), true);

        $file_data['testing'] = $start;

        file_put_contents($file, json_encode($file_data));

        if ($start) {
            exec("php artisan migrate:fresh --seed", $output);
            echo json_encode($output, JSON_PRETTY_PRINT);
        }
    }
}
