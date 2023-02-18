<?php
namespace Application\Testing\Acceptance;

use Application\Modules\Core\Users\Users_Model;
use Application\Testing\BaseTest;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEquals;

class T006_UsersTest extends BaseTest
{
    private $data = <<<JSON
    {
            "name": "new_role",
            "title": "New Role",
            "description": "This is the new role",
            "color": "red",
            "user_id": "1",
            "status_id": "1"
    }
    JSON;

    public function test_view_user_profile()
    {
        $response = $this->sendAuthorizedRequest('/api/users/profile', 'GET');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');

    }

    public function test_view_user_types()
    {
        $response = $this->sendAuthorizedRequest('/api/users/user-types', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');

    }

    public function viewData()
    {
        $response = $this->sendAuthorizedRequest('/api/users', 'GET');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_view_user_details()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $response = $this->sendAuthorizedRequest("/api/users/${new_data['urid']}/view", 'GET');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_user_can_update_profile()
    {
        $this->login([
            'email' => 'demouser@gmail.com',
            'password' => 'secretss',
        ]);

        $data = [
            'name' => 'Demo Demo User',
            'email' => 'demouser@gmail.com'
        ];

        $response = $this->sendAuthorizedRequest("/api/users/profile/update", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
        $this->login_token = null;
    }

    public function test_change_user_password()
    {
        $view_data = $this->viewData();

        $count = count($view_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $view_data[1];

        $data = [
            'user_id' => $new_data['urid'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->sendAuthorizedRequest("/api/users/change-user-password", 'POST', $data);
        $response->assertStatus(200);

        $response_data = json_decode($response->getContent(), true);
        self::assertJson(json_encode($response->getContent()), 'Expected JSON. GOT ->' . $response->getContent());

        self::assertIsArray($response_data, 'NOT ARRAY ' . $response->getContent());

        assertArrayHasKey('status', $response_data);
        assertEquals($response_data['status'], true, 'Status is not True');
    }

    public function test_change_password()
    {
        $this->login([
            'email' => 'demouser@gmail.com',
            'password' => 'secretss',
        ]);

        $data = [
            'old_password' => 'secretss',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->sendAuthorizedRequest("/api/users/change-password", 'POST', $data);
        $response->assertStatus(200);

        $response_data = json_decode($response->getContent(), true);
        self::assertJson(json_encode($response->getContent()), 'Expected JSON. GOT ->' . $response->getContent());

        self::assertIsArray($response_data, 'NOT ARRAY ' . $response->getContent());

        assertArrayHasKey('status', $response_data);
        assertEquals($response_data['status'], true, 'Status is not True');

        $this->login_token = null;
    }

    public function test_change_user_permissions()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $record_data = $response_data[random_int(0, $count-1)];

        $data['user_id'] = $record_data['urid'];
        $data['permissions'] = [
            ['id'=>1, 'selected'=>true],
            ['id'=>2, 'selected'=>false],
            ['id'=>5, 'selected'=>true],
            ['id'=>7, 'selected'=>true],
        ];
        $response = $this->sendAuthorizedRequest("/api/users/change-permissions", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_change_user_roles()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $record_data = $response_data[random_int(0, $count-1)];

        $data['user_id'] = $record_data['urid'];
        $data['roles'] = [
            ['id'=>1, 'selected'=>true],
            ['id'=>2, 'selected'=>false],
        ];
        $response = $this->sendAuthorizedRequest("/api/users/change-roles", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_add_new_user()
    {
        $data = [
            'name' => 'newborn user',
            'email' => 'newbornuser@gmail.com',
            'user_type_id' => '2',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => '2',
        ];
        $response = $this->sendAuthorizedRequest("/api/users/save", 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_complete_new_user_registration()
    {
        $user = Users_Model::whereEmail('newbornuser@gmail.com')->first();
        $urid = $user->urid;

        $data = [
            'role_id' => '2',
            'user_type_id' => '2',
        ];

        $response = $this->sendAuthorizedRequest("/api/users/${urid}/complete-user-registration", 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_login_after_complete_registration()
    {
        $data = [
            'email' => 'newbornuser@gmail.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }



}
