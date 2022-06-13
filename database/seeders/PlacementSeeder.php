<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventory_placements')->insert([
            'placementNumber' => 'PL-001',
            'placementDate' => '2022-01-01',
            'userId' => 1,
            'locationId' => 1,
            'placementDescription' => 'Placement 1',
            'placementType' => 1,

        ]);
    }
}
