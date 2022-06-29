<?php

namespace App\Imports;

use App\Models\Suppliers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class SupplierImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Suppliers([
            'supplierName' => $row[0],
            'supplierAddress' => $row[1],
            'supplierNumber' => $row[2],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    // public function headingRow(): int
    // {
    //     return 2;
    // }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
