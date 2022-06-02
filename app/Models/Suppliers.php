<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'supplierName',
        'supplierAddress',
        'supplierNumber',
    ];

    protected $hidden = [];

    public function productInventory() {
        return $this->hasMany(ProductInventory::class, 'productOrigin', 'id');
    }

    public function inventoryProcurement() {
        return $this->hasMany(InventoryProcurement::class, 'supplierId', 'id');
    }
}
