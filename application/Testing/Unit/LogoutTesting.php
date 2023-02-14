<?php

namespace Application\Testing\Unit;

use Application\Modules\Core\Users\Users_Model;
use Application\Testing\BaseTest;

class LogoutTesting extends BaseTest
{
    public function test_user_can_logout_successfully()
    {
        $this->login();
        $response = $this->sendLogoutRequest();

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $response = $this->get('/api/user',[
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
        $response->assertJsonPath('status', false);
    }

    private function sendLogoutRequest() {
        return $this->post('/api/logout',[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->login_token,
        ]);
    }

    public function test_user_cannot_logout_with_unknown_token()
    {
        $this->login_token = '';
        $response = $this->sendLogoutRequest();

        $response->assertStatus(401);
    }

    public function test_user_cannot_logout_with_previous_logged_out_token()
    {
        $this->login();
        $response = $this->sendLogoutRequest();

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $response = $this->sendLogoutRequest();
        $response->assertStatus(500);
    }


}
