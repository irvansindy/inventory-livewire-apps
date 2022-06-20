<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class ProductInventory extends Model
{
    use HasFactory, SoftDeletes, AutoNumbertrait;

    protected $table = 'product_inventories';

    protected $fillable = [
        'inventoryCode',
        'productId',
        'purchasingNumber',
        'registeredDate',
        'yearOfEntry',
        'yearOfUse',
        'serialNumber',
        'yearOfEnd',
        'sertificateNumber',
        'sertificateMaker',
        'productOrigin',
        'productPrice',
        'productDescription',
        'productStatus',
        'inventoryImageUrl'
    ];

    protected $hidden = [];

    public function products()
    {
        return $this->belongsTo(Products::class, 'productId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sertificateMaker', 'id');
    }

    public function supplier() {
        return $this->belongsTo(Suppliers::class, 'productOrigin', 'id');
    }

    // public function inventoryPlacement()
    // {
    //     return $this->hasMany(InventoryPlacement::class, 'inventoryCode', 'inventoryCode');
    // }
    
    public function getAutoNumberOptions()
    {
        return [
            'inventoryCode' => [
                'format' => function () {
                    return 'INVT/' . date('Ymd') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 3, // The number of digits in the autonumber
            ],
        ];
    }
}
