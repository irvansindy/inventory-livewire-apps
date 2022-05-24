<?php

namespace App\Http\Livewire\Product;

use App\Models\Products;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class ProductsDataTable extends LivewireDatatable
{
    public $model = Products::class;
    public $exportable = true;

    public function columns()
    {
        return [
            Column::name('productCode')->searchable()->label('Code'),
            Column::name('productName')->searchable()->label('Name'),
            Column::name('categoryId')->searchable()->label('Category'),
            Column::name('merk')->searchable(),
            Column::name('qty'),
            Column::name('minimumStock')->label('Min. Stock'),
            Column::callback(['id', 'productName'], function ($id, $productName) {
                return view('livewire.product.table-actions', ['id' => $id, 'productName' => $productName]);
            })->label('Actions'),
        ];
    }
}