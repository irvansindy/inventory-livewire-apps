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
        return ProductInventory::with([
            'products:productName',
            'supplier:supplierName',
            'user:name'
        ])->get();
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
            'Inventory Code',
            'Product Name',
            'Merk',
            'Serial Number',
            'Purchasing Number',
            'Product Supplier',
            'Price',
            'Register Date',
            'Year of Entry',
            'Year of Use',
            'Status',
        ];
    }
}
