<?php
namespace Application\Testing\Acceptance\System;

use Application\Testing\BaseTest;

class T001_DashboardsTest extends BaseTest
{
    public function test_view_dashboard()
    {
        $response = $this->sendAuthorizedRequest('/api/dashboard', 'GET');

        $response->assertStatus(200);

        $response->assertJsonPath('status', true);

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['data'], 'Data Key in response is Empty');

    }

}
