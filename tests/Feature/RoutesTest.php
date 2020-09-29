<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Assert as PHPUnit;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoutesHaveNoServerErrors()
    {
        $routes = collect(app('router')->getRoutes())->map(function ($route) {
            return ['methods' => $route->methods(), 'uri' => $route->uri()];
        })->filter()->all();
        $errors = [];

        foreach ($routes as $route) {
            foreach ($route['methods'] as $method) {
                $response = $this->call($method, $route['uri']);

                $statusCode = $response->getStatusCode();

                if (500 <= $statusCode && $statusCode <= 599) {
                    array_push($errors, $statusCode.' '.$method.' '.$route['uri']);
                }
            }
        }

        PHPUnit::assertEmpty($errors, join("\n", $errors));
    }
}
