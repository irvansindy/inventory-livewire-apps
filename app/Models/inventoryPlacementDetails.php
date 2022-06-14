<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryPlacementDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory_placement_details';

    protected $fillable = [
        'placementId',
        'productInventoryId',
        'status',
    ];

    protected $hidden = [];

    public function placement()
    {
        return $this->hasOne(InventoryPlacement::class, 'id', 'placementId');
    }
}
