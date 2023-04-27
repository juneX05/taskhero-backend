<?php
namespace Application\Testing\Acceptance;

use Application\Modules\Core\Roles\Roles_Model;
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
        $this->test_creating_new_role();

        $new_data = Roles_Model::whereName('new_role')
            ->first()->toArray();

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
        $record_data = Roles_Model::whereName('super_admin')
            ->first()->toArray();

        $data['permissions'] = [
            "1" => "given",
            "2" => "not_given",
            "5" => "given",
            "7" => "given",
        ];
        $response = $this->sendAuthorizedRequest("/api/roles/${record_data['urid']}/change-permissions", 'POST', $data);
        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_deactivate_role()
    {
        $record_data = Roles_Model::whereName('super_admin')
            ->first()->toArray();

        $data['reason'] = "Just deactivate";
        $response = $this->sendAuthorizedRequest("/api/roles/${record_data['urid']}/deactivate", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_activate_role()
    {
        $record_data = Roles_Model::whereName('super_admin')
            ->first()->toArray();

        $data['reason'] = "Just activate";
        $response = $this->sendAuthorizedRequest("/api/roles/${record_data['urid']}/activate", 'POST', $data);

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
