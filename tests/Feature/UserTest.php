<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Model\User;
use App\Model\UserDetail;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        // $this->artisan('db:seed');
        $this->artisan('passport:install');

        $this->user = factory(\App\Model\User::class)->create();

    }

    public function test_a_user_request_update() {
        $this->withoutExceptionHandling();

        $auth = $this->actingAs($this->user, 'api');

        $user = factory('App\Model\User')->create();

        $userDetail = factory('App\Model\UserDetail')->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'id'            => $user->id,
            'first_name'    => $this->faker->firstName(),
            'last_name'     => $this->faker->lastName(),
            'email'         => $this->faker->unique()->safeEmail,
            // 'address'       => $this->faker->address(),
            // 'gender'        => 'male',
        ];

        $res = $this->patch('/api/v1/user/update/' . $user->id, $data);
        $res->assertStatus(200);

    }

    public function test_a_user_request_destroy() {
        // auth user
        $auth = $this->actingAs($this->user, 'api');
        
        $user = factory('App\Model\User')->create();
        
        $userDetail = factory('App\Model\UserDetail')->create([
            'user_id' => $user->id,
        ]);

        $res = $this->delete('/api/v1/user/destroy/'.$user->id, []);

        $res->assertStatus(200);
    }

    public function test_a_user_request_reset_password_to_default() {
        // auth user
        $auth = $this->actingAs($this->user, 'api');
        
        $user = factory('App\Model\User')->create();
        
        $userDetail = factory('App\Model\UserDetail')->create([
            'user_id' => $user->id,
        ]);

        $res = $this->patch('/api/v1/user/reset-password/'.$user->id, []);

        $res->assertStatus(200);
    }

    public function test_a_user_request_change_password() {
        // auth user
        $auth = $this->actingAs($this->user, 'api');
        
        $user = factory('App\Model\User')->create();
        
        $userDetail = factory('App\Model\UserDetail')->create([
            'user_id' => $user->id,
        ]);

        $res = $this->patch('/api/v1/user/change-password', [
            'id'                => $user->id,
            'current_password'  => 'secret', 
            'new_password'      => 'secret123', 
            'confirm_password'  => 'secret123', 
        ]);

        $res->assertStatus(200);
    }
}
