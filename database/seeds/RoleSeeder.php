<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'          => 'admin',
                'description'   => 'This is for admin role',
            ],[
                'name'          => 'user',
                'description'   => 'This is for user role',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
