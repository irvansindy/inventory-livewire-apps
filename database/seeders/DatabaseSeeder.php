<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            ProductCategoriesSeeder::class,
            ProcurementTypesSeeder::class,
            PlacementSeeder::class,
            PlacementDetailsSeeder::class,
            Location::class,
            InventoryProcurementSeeder::class,
            InventoryProcurementDetailsSeeder::class,
            Department::class,
        ]);
    }
}
