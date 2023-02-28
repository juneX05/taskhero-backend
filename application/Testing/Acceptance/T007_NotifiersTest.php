<?php
namespace Application\Testing\Acceptance;

use Application\Modules\Core\Users\Users_Model;
use Application\Testing\BaseTest;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEquals;

class T007_NotifiersTest extends BaseTest
{

    private $data = <<<JSON
    {
        "name": "new_notifier",
        "title": "New Notifier",
        "message": "This is a new message for the notifiers",
        "status_id": 1
    }
    JSON;

    public function test_creating_notifier()
    {
        $data = json_decode($this->data, true);
        $response = $this->sendAuthorizedRequest('/api/notifiers/save', 'POST', $data);

        $response->assertStatus(200);

        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');

    }

    public function viewData()
    {
        $response = $this->sendAuthorizedRequest('/api/notifiers', 'GET');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_view_notifier_details()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $response = $this->sendAuthorizedRequest("/api/notifiers/${new_data['urid']}/view", 'GET');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_update_notifier_details()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];
        $new_data['title'] =  'New new title';

        $response = $this->sendAuthorizedRequest("/api/notifiers/{$new_data['urid']}/update", 'POST', $new_data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
        $this->login_token = null;
    }

    public function test_deactivate_notifier()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[0];

        $response = $this->sendAuthorizedRequest("/api/notifiers/{$new_data['urid']}/deactivate", 'POST');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
        $this->login_token = null;
    }

    public function test_activate_notifier()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[0];

        $response = $this->sendAuthorizedRequest("/api/notifiers/{$new_data['urid']}/activate", 'POST');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
        $this->login_token = null;
    }

}
