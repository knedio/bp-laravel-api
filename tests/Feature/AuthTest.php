<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        
        // $this->artisan('db:seed');
        $this->artisan('passport:install');
    }

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

    public function test_a_auth_request_login() {
        // create user
    	$user = factory('App\Model\User')->create();

        $userDetail = factory('App\Model\UserDetail')->create([
            'user_id' => $user->id,
        ]);

    	$res = $this->post('/api/v1/auth/login', ['email' => $user->email, 'password' => 'secret']);

        $res->assertSeeText('token');

    }

    public function test_a_auth_request_store() {
        $this->withoutExceptionHandling();
        
        $password = $this->faker->password();

        $data = [
            'first_name'     => $this->faker->firstName(),
            'last_name'      => $this->faker->lastName(),
            'email'         => $this->faker->unique()->safeEmail,
            'password'          => $password,
            'confirm_password'  => $password,
        ];
        
        $res = $this->json('POST', '/api/v1/auth/store', $data);
        $res->assertStatus(200);
    }

    // public function test_a_user_request_change_password() {
    //     // auth user
    //     $auth = $this->actingAs($this->user, 'api');
        
    //     $user = factory('App\Model\User')->create();
        
    //     $userDetail = factory('App\Model\UserDetail')->create([
    //         'user_id' => $user->id,
    //     ]);

    //     $res = $this->patch('/api/v1/user/change-password', [
    //         'email'             => $user->email,
    //         'current_password'  => 'secret', 
    //         'password_token'    => 'secret123', 
    //         'confirm_password'  => 'secret123', 
    //     ]);

    //     $res->assertStatus(200);
    // }

}
