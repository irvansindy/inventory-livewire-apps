<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryProcurementDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory_procurement_details';

    protected $fillable = [
        'procurementId',
        'productId',
        'inventoryName',
        'specification',
        'quantity',
        'unitPrice',
        'imageUrl',
    ];

    protected $hidden = [];

    public function procurement() {
        return $this->hasOne(InventoryProcurement::class, 'id', 'procurementId');
    }

    public function product() {
        return $this->hasOne(Products::class, 'id', 'productId');
    }
}
