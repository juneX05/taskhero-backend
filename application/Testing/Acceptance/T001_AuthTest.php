<?php
namespace Application\Testing\Acceptance;

use Application\Testing\BaseTest;
use Illuminate\Support\Facades\DB;

class T001_AuthTest extends BaseTest
{
    private $data = <<<JSON
    {
        "email": "admin@gmail.com",
        "password": "secretss"
    }
    JSON;

    public function test_user_can_register()
    {
        $data = [
            'name' => 'New User',
            'email' => 'new_user@gmail.com',
            'password' => 'newpassword',
            'confirm_password' => 'newpassword'
        ];
        $response = $this->post('/api/register', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_user_can_login_through_mobile()
    {
        $response = $this->post('/api/mobile/login', json_decode($this->data, true));
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
    }

    public function test_user_can_login_through_spa()
    {
        $response = $this->post('/api/spa/login', json_decode($this->data, true));
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
    }

    public function test_user_can_initiate_forgot_password() {
        $response = $this->sendAuthorizedRequest('/api/forgot-password', 'POST', [
            'email' => 'user@gmail.com'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_user_can_reset_password() {

        $this->test_user_can_initiate_forgot_password();

        $reset_token = DB::table('password_reset_tokens')
            ->where('email', 'user@gmail.com')->first();
        $reset_token = (array) $reset_token;

        $data=[
            'email' => 'user@gmail.com',
            'token' => $reset_token['token'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->sendAuthorizedRequest("/api/password/reset", 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_user_can_login_with_new_password_after_resetting() {
        $data=[
            'email' => 'user@gmail.com',
            'password' => 'password',
        ];

        $this->test_user_can_reset_password();

        $response = $this->sendNormalRequest("/api/mobile/login", 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

}
