<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            'supplierName' => 'Supplier 1',
            'supplierAddress' => 'Jl. Kebon Kacang',
            'supplierNumber' => '0812341234',
        ]);
    }
}
