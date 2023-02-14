<?php
namespace Application\Testing\Acceptance;

use Application\Testing\BaseTest;

class T001_AuthTest extends BaseTest
{
    private $data = <<<JSON
    {
        "email": "admin@gmail.com",
        "password": "secretss"
    }
    JSON;

    public function test_user_can_login()
    {
        $response = $this->post('/api/login', json_decode($this->data, true));

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
    }

    public function test_get_current_logged_in_user_details() {
        $response = $this->sendAuthorizedRequest('/api/user', 'GET');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $response_data = json_decode($response->getContent(), true);
        $data = $response_data['data'];

        $this->assertNotEmpty($data);
    }

    public function test_user_can_logout() {
        $response = $this->sendAuthorizedRequest('/api/logout', 'POST');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $response = $this->get('/api/user',[
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
        $response->assertJsonPath('status', false);
    }

}