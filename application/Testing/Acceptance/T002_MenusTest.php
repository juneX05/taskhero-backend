<?php
namespace Application\Testing\Acceptance;

use Application\Testing\BaseTest;

class T002_MenusTest extends BaseTest
{
    private $data = <<<JSON
    {
        "name": "users",
        "title": "Users",
        "icon": "fa-user",
        "link": "#",
        "parent": null,
        "type": "link",
        "position": "7",
        "category": "app",
        "auth": null,
        "sidebar_visibility": "1",
        "navbar_visibility": "0",
        "file_link": null,
        "permission_name": "view_users"
    }
    JSON;

    public function test_creating_new_menu()
    {
        $data = json_decode($this->data, true);
        $data['name'] = 'new_menus';
        $data['title'] = 'New Menus';
        $response = $this->sendAuthorizedRequest('/api/menus/save', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');
        $this->assertNotEmpty($data['data']['urid'], 'Urid Key in data is Empty');

        $this->menu_urid = $data['data']['urid'];
    }

    public function viewMenus()
    {
        $response = $this->sendAuthorizedRequest('/api/menus', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');

        return $data['data'];
    }

    public function test_view_menus_routes()
    {
        $response = $this->sendAuthorizedRequest('/api/menus/routes', 'GET');
        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        assert(gettype($data) === "array", 'Weird, Response Data is not array.');
    }

    public function test_view_parent_menus()
    {
        $response = $this->sendAuthorizedRequest('/api/menus/parent', 'GET');

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data, 'Data is not array.');
    }

    public function test_updating_menu()
    {
        $response_data = $this->viewMenus();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $data = json_decode($this->data, true);
        $data['name'] = 'new_menus_update';
        $data['title'] = 'New Menus Update';
        $data['urid'] = $new_data['urid'];
        $response = $this->sendAuthorizedRequest('/api/menus/update', 'POST', $data);

        $response_data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);

        $this->assertIsArray($response_data, 'Data is not array.');
    }

    public function test_updating_menu_position()
    {
        $response_data = $this->viewMenus();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];
        $swap_data = $response_data[random_int(0, $count-1)];

        $data = json_decode($this->data, true);
        $data['referred_after_urid'] = $new_data['urid'];
        $data['urid'] = $swap_data['urid'];
        $response = $this->sendAuthorizedRequest('/api/menus/update-positions', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

    public function test_deleting_menu()
    {
        $response_data = $this->viewMenus();

        $count = count($response_data);
        assert($count > 0, 'Weird, No Test Data');

        $new_data = $response_data[random_int(0, $count-1)];

        $data = json_decode($this->data, true);
        $data['urid'] = $new_data['urid'];

        $response = $this->sendAuthorizedRequest('/api/menus/delete', 'POST', $data);

        $response->assertStatus(200);
        $response->assertJsonPath('status', true);
    }

}
