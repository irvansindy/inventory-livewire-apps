<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InventoryProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventory_procurements')->insert([
            'procurementCode' => 'PRC/' . date('ym') . '/0001',
            'userId' => 1,
            'supplierId' => 1,
            'procurementTypeId' => 1,
            'procurementDescription' => 'Pembelian Barang',
            'procurementDate' => '2020-01-01',
            'supplierId' => 1,
            'totalPrice' => 100000,
            'status' => 0,
        ]);
    }
}
