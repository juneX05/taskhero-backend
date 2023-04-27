<?php
namespace Application\Testing\Acceptance;

use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Testing\BaseTest;

class T004_PermissionsTest extends BaseTest
{
    private $data = <<<JSON
    {
            "name": "new_permission",
            "title": "New Permission",
            "description": "This is the new permission",
            "module_id": "permissions"
    }
    JSON;

    public function test_creating_new_permission()
    {
        $data = json_decode($this->data, true);
        $response = $this->sendAuthorizedRequest('/api/permissions/save', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');
        $this->assertNotEmpty($data['data']['urid'], 'Urid Key in data is Empty');

    }

    public function test_view_all_permissions()
    {
        $response = $this->sendAuthorizedRequest('/api/permissions', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_updating_permission()
    {
        $this->test_creating_new_permission();

        $new_data = Permissions_Model::whereName('new_permission')
            ->first()->toArray();

        $data = json_decode($this->data, true);
        $data['name'] = 'new_updated_permission';
        $data['title'] = 'New Permission Update';
        $data['urid'] = $new_data['urid'];
        $response = $this->sendAuthorizedRequest('/api/permissions/update', 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }
}
