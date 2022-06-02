<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InventoryProcurementDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventory_procurement_details')->insert([
            'procurementId' => 1,
            'productId' => 1,
            'description' => 'Laptop',
            'quantity' => 1,
            'unitPrice' => 14000000,
        ]);
    }
}
