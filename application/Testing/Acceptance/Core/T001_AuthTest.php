<?php
namespace Application\Testing\Acceptance\Core;

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

    private $registration_data = [
        'name' => 'New User',
        'email' => 'new_user@gmail.com',
        'password' => 'newpassword',
        'confirm_password' => 'newpassword'
    ];

    private $initiate_forgot_password_email = "user@gmail.com";

    private $reset_password_data = [
        'email' => 'user@gmail.com',
        'token' => "",
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    private $login_with_new_password_after_resetting_data = [
        'email' => 'user@gmail.com',
        'password' => 'password',
    ];

    public function test_user_can_register()
    {
        $data = $this->registration_data;
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
            'email' => $this->initiate_forgot_password_email
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_user_can_reset_password() {

        //Uncomment this if you want to test only this test
//        $this->test_user_can_initiate_forgot_password();

        $data= $this->reset_password_data;

        $reset_token = DB::table('password_reset_tokens')
            ->where('email', $data['email'])->first();
        $reset_token = (array) $reset_token;

        $data['token'] = $reset_token['token'];

        $response = $this->sendAuthorizedRequest("/api/password/reset", 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_user_can_login_with_new_password_after_resetting() {

        //Uncomment this if you want to test only this test
//        $this->test_user_can_reset_password();

        $data= $this->login_with_new_password_after_resetting_data;
        $response = $this->sendNormalRequest("/api/mobile/login", 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

}
