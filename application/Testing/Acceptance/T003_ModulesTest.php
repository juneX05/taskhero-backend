<?php
namespace Application\Testing\Acceptance;

use Application\Testing\BaseTest;

class T003_ModulesTest extends BaseTest
{
    private $data = <<<JSON
    {
            "name": "new_module",
            "title": "New Module",
            "description": "This is the new module",
            "status_id": "1"
    }
    JSON;

    public function test_creating_new_module()
    {
        $data = json_decode($this->data, true);
        $response = $this->sendAuthorizedRequest('/api/modules/save', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');
        $this->assertNotEmpty($data['data']['urid'], 'Urid Key in data is Empty');

    }

    public function viewData()
    {
        $response = $this->sendAuthorizedRequest('/api/modules', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_get_modules_statuses()
    {
        $response = $this->sendAuthorizedRequest('/api/modules/statuses', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');
    }

    public function test_updating_module()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $data = json_decode($this->data, true);
        $data['name'] = 'new_updated_module';
        $data['title'] = 'New Module Update';
        $data['urid'] = $new_data['urid'];
        $response = $this->sendAuthorizedRequest('/api/modules/update', 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_change_module_status()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $data = json_decode($this->data, true);
        $data['status_id'] = 2;
        $data['urid'] = $new_data['urid'];
        $response = $this->sendAuthorizedRequest('/api/modules/change-status', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_view_module_details()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $response = $this->sendAuthorizedRequest("/api/modules/${new_data['urid']}/view", 'GET');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

}
