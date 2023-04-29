<?php

namespace Application\Testing\Unit\Core;

use Application\Modules\Core\Users\Users_Model;
use Application\Testing\BaseTest;


class LoginTest extends BaseTest
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
    }

    private function sendLoginRequest($data) {
        return $this->post('/api/login', $data);
    }

    public function test_user_cannot_login_with_null_email()
    {
        $data = json_decode($this->data, true);
        $data['email'] = '';

        $response = $this->sendLoginRequest($data);

        $response->assertStatus(422);
    }

    public function test_user_cannot_login_with_null_password()
    {
        $data = json_decode($this->data, true);
        $data['password'] = '';

        $response = $this->sendLoginRequest($data);

        $response->assertStatus(422);
    }

    public function test_user_cannot_login_with_wrong_credentials()
    {
        $data = json_decode($this->data, true);
        $data['email'] = 'new@gmail.com';
        $data['password'] = 'newpassword';

        $response = $this->sendLoginRequest($data);

        $response->assertStatus(401);
    }

    public function test_user_cannot_login_with_correct_email_but_wrong_password()
    {
        $data = json_decode($this->data, true);
        $data['password'] = 'newpassword';

        $response = $this->sendLoginRequest($data);

        $response->assertStatus(401);
    }

    public function test_user_cannot_login_if_account_is_not_active()
    {
        $data = json_decode($this->data, true);

        $user = Users_Model::whereEmail($data['email'])->first();
        $user->update(['user_status_id' => 2]);

        $data['password'] = 'newpassword';

        $response = $this->sendLoginRequest($data);

        $response->assertStatus(401);
    }
}
