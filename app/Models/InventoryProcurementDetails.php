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
        'description',
        'quantity',
        'unitPrice',
    ];

    protected $hidden = [];

    public function procurement() {
        return $this->hasOne(InventoryProcurement::class, 'id', 'procurementId');
    }
}
