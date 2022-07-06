<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@gmail.com',
                    'roles' => 'SUPERADMIN',
                    'username' => 'super_admin',
                    'nik' => '876678986',
                    'parentUserId' => 1,
                    'password' => Hash::make('superadmin123'),
                ],
                [
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'roles' => 'ADMIN',
                    'username' => 'admin',
                    'nik' => '0123456789',
                    'parentUserId' => 1,
                    'password' => Hash::make('admin12345'),
                ],
                [
                    'name' => 'Irvan Sindy',
                    'email' => 'user1@gmail.com',
                    'roles' => 'USER',
                    'username' => 'user1',
                    'nik' => '0123456789',
                    'parentUserId' => 2,
                    'password' => Hash::make('user12345'),
                ],
            ]
        );
    }
}
