<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class InventoryProcurement extends Model
{
    use HasFactory, AutoNumberTrait, SoftDeletes;

    protected $table = 'inventory_procurements';

    protected $fillable = [
        'procurementCode',
        'userId',
        'supplierId',
        'procurementTypeId',
        'procurementDescription',
        'procurementDate',
        'totalPrice',
        'status',
    ];

    protected $hidden = [];

    public function user() {
        return $this->belongsTO(User::class, 'userId', 'id');
    }

    public function products() {
        return $this->hasMany(Products::class, 'id', 'productId');
    }

    public function supplier() {
        return $this->belongsTo(Suppliers::class, 'supplierId', 'id');
    }

    public function procurementType() {
        return $this->belongsTo(ProcurementType::class, 'procurementTypeId', 'id');
    }

    public function procurementDetails() {
        return $this->hasMany(InventoryProcurementDetails::class, 'procurementId', 'id');
    }

    public function getAutoNumberOptions()
    {
        return [
            'procurementCode' => [
                'format' => function () {
                    return 'PRC/' . date('Ymd') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 4, // The number of digits in the autonumber
            ],
        ];
    }
}
