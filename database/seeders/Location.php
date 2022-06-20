<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Location extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert(
            [
                [
                'locationName' => 'HO',
                'departmentId' => 1,
                ],
                [
                'locationName' => 'CIMG',
                'departmentId' => 2,
                ],
                [
                'locationName' => 'KRW',
                'departmentId' => 3,
                ]
            ]

        );
    }
}
