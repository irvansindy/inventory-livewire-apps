<?php

namespace App\Exports;

use App\Models\ProductInventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductInventoryExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductInventory::join(
            'products', 'products.id', '=', 'product_inventories.productId',
            )->join(
                'suppliers', 'suppliers.id', '=', 'product_inventories.productOrigin',
            )->join(
                'users', 'users.id', '=', 'product_inventories.sertificateMaker',
            )
            ->get([
            'product_inventories.inventoryCode', 
            'products.productName',
            'products.merk',
            'product_inventories.serialNumber', 
            'product_inventories.purchasingNumber', 
            'suppliers.supplierName',
            'product_inventories.productPrice', 
            'product_inventories.registeredDate', 
            'product_inventories.yearOfEntry', 
            'product_inventories.yearOfUse', 
            'product_inventories.productStatus', 
            'users.name'
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return [
            'Inventory Code', //inventory table
            'Product Name',
            'Merk',
            'Serial Number', //inventory table
            'Purchasing Number', //inventory table
            'Product Supplier', 
            'Price',
            'Register Date', //inventory table
            'Year of Entry', //inventory table
            'Year of Use', //inventory table
            'Status', //inventory table
            'Sertificate Maker' //inventory table
        ];
    }
}
