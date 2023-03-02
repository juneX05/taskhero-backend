<?php
namespace Application\Testing\Acceptance;

use Application\Modules\Core\Users\Users_Model;
use Application\Testing\BaseTest;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEquals;

class T008_DashboardsTest extends BaseTest
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
