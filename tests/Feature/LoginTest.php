<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserCanViewLoginPage()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
    }

    public function testUserCanLoginWithValidCredentials()
    {

        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => $password,
            'role_id' => 1,
            '_token' => \Session::token(),

        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(302);
    }
}
