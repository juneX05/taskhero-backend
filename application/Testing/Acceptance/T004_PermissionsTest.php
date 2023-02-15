<?php
namespace Application\Testing\Acceptance;

use Application\Testing\BaseTest;

class T004_PermissionsTest extends BaseTest
{
    private $data = <<<JSON
    {
            "name": "new_permission",
            "title": "New Permission",
            "description": "This is the new permission",
            "module_id": "7"
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

    public function viewData()
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
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

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
