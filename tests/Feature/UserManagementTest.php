<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Countable;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * Patient will no have access on the web
     */
    public function patientWillNoHaveAccessToWeb()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 3,
        ]);

        $response = $this->json('POST','/authenticate', [
            'email' => $user->email,
            'password' => bcrypt($user->password),
            'role_id' => 3,
        ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     * Check if the user with no authentication will redirect to login page.
     *
     * @return void
     */
    public function checkIfAdminIsRedirectedToLoginPageWithOutAuthentication()
    {
        $response = $this->get('/user/list');
        $response->assertRedirect('/');
    }

    /**
     * @test
     * Only logged in user can see user list page
     */
    public function authenticated_users_can_access_user_list()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);
        $response1 = $this->get('/user/list');
        $response1->assertOk();
    }

    /**
     * @test
     * create a admin user
     */
     public function createAdminUser()
     {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);
        $response = $this->get('/user/create/admin/1');
        $response->assertStatus(200);
        $this->json('POST', '/user/create/admin', [
            'first_name' => 'Sam',
            'last_name' => 'Smith',
            'email' => 'samsmith@gmail.com',
            'role_id' => 2,
            'name' => 'Sam Smith',
        ]);
        $user = User::get()->last();
        $this->followingRedirects();
     }
     /**
      * @test
      * create a staff
      */
     public function createStaffUser()
     {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
        ]);

        Auth::login($user);
        $response = $this->get('/user/create/staff/1');
        $response->assertStatus(200);
        $this->json('POST', '/user/create/staff', [
            'first_name' => 'Sam',
            'last_name' => 'Smith',
            'email' => 'samsmith@gmail.com',
            'role_id' => 4,
            'name' => 'Sam Smith',
            'clinic_id' => 1,            
        ]);
        $user = User::get()->last();
        $this->followingRedirects();
     }
}
