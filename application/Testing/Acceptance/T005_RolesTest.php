<?php
namespace Application\Testing\Acceptance;

use Application\Testing\BaseTest;

class T005_RolesTest extends BaseTest
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

    public function test_creating_new_role()
    {
        $data = json_decode($this->data, true);
        $response = $this->sendAuthorizedRequest('/api/roles/save', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');
        $this->assertNotEmpty($data['data']['urid'], 'Urid Key in data is Empty');

    }

    public function viewData()
    {
        $response = $this->sendAuthorizedRequest('/api/roles', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_view_role_details()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $response = $this->sendAuthorizedRequest("/api/roles/${new_data['urid']}/view", 'GET');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_updating_role()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $data = json_decode($this->data, true);
        $data['name'] = 'new_updated_role';
        $data['title'] = 'New Role Update';
        $data['urid'] = $new_data['urid'];
        $response = $this->sendAuthorizedRequest("/api/roles/${new_data['urid']}/update", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_change_role_permissions()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $record_data = $response_data[random_int(0, $count-1)];

        $data['permissions'] = [
            ['id'=>1, 'selected'=>true],
            ['id'=>2, 'selected'=>false],
            ['id'=>5, 'selected'=>true],
            ['id'=>7, 'selected'=>true],
        ];
        $response = $this->sendAuthorizedRequest("/api/roles/${record_data['urid']}/change-permissions", 'POST', $data);
        echo $response->getContent();
        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_change_role_status()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $record_data = $response_data[random_int(0, $count-1)];

        $data['status_id'] = 1;
        $response = $this->sendAuthorizedRequest("/api/roles/${record_data['urid']}/change-status", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_view_statuses()
    {
        $response = $this->sendAuthorizedRequest("/api/roles/statuses", 'GET');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }
}
