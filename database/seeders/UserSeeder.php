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
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'roles' => 'ADMIN',
                    'username' => 'admin',
                    'nik' => '0123456789',
                    'password' => Hash::make('admin12345'),
                ],
                [
                    'name' => 'user',
                    'email' => 'user@gmail.com',
                    'roles' => 'USER',
                    'username' => 'user',
                    'nik' => '0123456789',
                    'password' => Hash::make('user12345'),
                ]
            ]
        );
    }
}
