<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'productCode' => 'PRO/' . date('ym') . '/0001',
            'productName' => 'Laptop',
            'categoryId' => 1,
            'productDescription' => 'Laptop',
            'merk' => 'HP',
            'qty' => 10,
            'minimumStock' => 2,
        ]);
    }
}
