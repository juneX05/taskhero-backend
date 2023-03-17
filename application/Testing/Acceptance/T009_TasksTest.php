<?php
namespace Application\Testing\Acceptance;

use Application\Modules\Core\Roles\Roles_Model;
use Application\Modules\System\Tasks\Tasks_Model;
use Application\Testing\BaseTest;

class T009_TasksTest extends BaseTest
{
    private $data = <<<JSON
    {
            "title": "New Task",
            "description": "<p>This is the new task</p>",
            "assigned_users": [1,2,3],
            "priority_id": 1,
            "project_id": 1,
            "task_status_id": "1",
            "start_date": "2023-05-05",
            "end_date": "2023-05-10",
            "tags": ["update","hot"]
    }
    JSON;

    public function test_creating_new_task_with_full_details()
    {
        $data = json_decode($this->data, true);
        $response = $this->sendAuthorizedRequest('/api/tasks/save', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');
        $this->assertNotEmpty($data['data']['urid'], 'Urid Key in data is Empty');

    }

    public function viewData()
    {
        $response = $this->sendAuthorizedRequest('/api/tasks', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_view_task_details()
    {
        $response_data = $this->viewData();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $response = $this->sendAuthorizedRequest("/api/tasks/${new_data['urid']}/view", 'GET');

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_updating_task()
    {
        $new_data = Tasks_Model::where('title' , 'New Task')
            ->first()->toArray();

        $data = json_decode($this->data, true);
        $data['title'] = 'New Task Update';
        $data['urid'] = $new_data['urid'];
        $response = $this->sendAuthorizedRequest("/api/tasks/${new_data['urid']}/update", 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }
}
