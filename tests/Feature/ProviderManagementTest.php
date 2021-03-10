<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProviderManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function indexPage()
    {
        $response = $this->json('GET', '/provider/list')
             ->seeJson([
                'created' => true,
             ]);
        $response->assertStatus(200);
    }
}
