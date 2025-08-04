<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(array(
            0 =>
            array(
                'id' => 1,
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@fastit.com',
                'phone' => NULL,
                'address' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$3XDnFRPsCSuf8StyUiv3MOJgC/Xo7fP68aT0s6cZP4noWKW98OEhe',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'image' => NULL,
                'remember_token' => NULL,
                'status' => 1,
                'last_login' => NULL,
                'created_at' => '2023-11-15 15:47:05',
                'updated_at' => '2023-11-15 15:47:05',
            ),
            1 =>
            array(
                'id' => 2,
                'role_id' => 2,
                'name' => 'Super Admin',
                'email' => 'superadmin@fastit.com',
                'phone' => NULL,
                'address' => NULL,
                'email_verified_at' => NULL,
                'password' => Hash::make('fast@superadmin'),
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'image' => NULL,
                'remember_token' => NULL,
                'status' => 0,
                'last_login' => NULL,
                'created_at' => '2023-11-15 15:47:05',
                'updated_at' => '2023-11-15 15:47:05',
            ),
        ));
    }
}
