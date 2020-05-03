<?php

use Illuminate\Database\Seeder;
use App\Model\User;
use App\Model\UserDetail;
use App\Model\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email'     => 'admin@gmail.com',
                'firstName' => 'John',
                'middleName'=> '',
                'lastName'  => 'Joe',
                'address'   => 'CDO',
                'gender'    => 'male',
                'phoneNo'   => '09652354567',
                'role_id'    => 1
            ],[
                'email'     => 'user@gmail.com',
                'firstName' => 'Mike',
                'middleName'=> '',
                'lastName'  => 'Joe',
                'address'   => 'CDO',
                'gender'    => 'male',
                'phoneNo'   => '09652354567',
                'role_id'    => 2
            ]
        ];

        foreach ( $users as $row ) {
            $user = User::create([
                'email'         => $row['email'],
                'password'      => bcrypt('12345678'),
                'remember_token'    => Str::random(10),
            ]);

            $detail = UserDetail::create([
                'user_id'       => $user->id,
                'firstName'     => $row['firstName'],
                'middleName'    => $row['middleName'],
                'lastName'      => $row['lastName'],
            ]);

            $role = UserRole::create([
                'user_id'   => $user->id,
                'role_id'   => $row['role_id'],
            ]);
        }
    }
}
