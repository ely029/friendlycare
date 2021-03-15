<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProviderManagementTest extends TestCase
{
    /**
     * @test
     * access to provider management list
     */
    public function accessProviderManagementList()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);

        $response = $this->get('/provider/list');
        $response->assertStatus(200);
    }

    /**
     * @test
     * access to create provider - first page
     */
    public function createProviderFirstPageAccess()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);
        $response = $this->get('provider/create/1');
        $response->assertStatus(200);
    }

     /**
     * @test
     * access to create provider - second page
     */
    public function createProviderSecondPageAccess()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);
        $response = $this->get('provider/create/2');
        $response->assertStatus(200);
    }

     /**
     * @test
     * access to create provider - third page
     */
    public function createProviderThirdPageAccess()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);
        $response = $this->get('provider/create/3');
        $response->redire;
    }
}
