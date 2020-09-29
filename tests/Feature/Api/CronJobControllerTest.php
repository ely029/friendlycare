<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class CronJobControllerTest extends TestCase
{
    public function testCronJobOnlyAvailableOnGCPAppEngine()
    {
        $response = $this->get('/api/cron');

        $response->assertUnauthorized();
    }

    public function testCronJobOnlyAvailableOnGCPForwarder()
    {
        $response = $this->get('/api/cron', ['x-appengine-cron' => 'true']);

        $response->assertForbidden();
    }

    public function testCronJobTriggersScheduleRun()
    {
        $response = $this->get('/api/cron', [
            'x-appengine-cron' => 'true',
            'x-forwarded-for' => '10.0.0.1',
        ]);

        $response->assertNoContent();
    }
}
