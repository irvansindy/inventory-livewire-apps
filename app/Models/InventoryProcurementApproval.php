<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryProcurementApproval extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory_procurement_approvals';

    protected $fillable = [
        'procurementId',
        'userId',
        'status',
        'comment',
        'signature',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function procurement()
    {
        return $this->hasOne(InventoryProcurement::class, 'id', 'procurementId');
    }
    // public function procurement()   
    // {
    //     return $this->belongsTo(InventoryProcurement::class, 'procurementId', 'id');
    // }
}
