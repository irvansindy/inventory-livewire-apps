<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class ProductInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_inventories';

    protected $fillable = [
        'inventaryCode',
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
    ];

    protected $hidden = [];

    public function products()
    {
        return $this->hasOne(Products::class, 'id', 'productId');
    }
    
    public function getAutoNumberOptions()
    {
        return [
            'inventaryCode' => [
                'format' => function () {
                    return 'INVT/' . date('ymd') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 3, // The number of digits in the autonumber
            ],
        ];
    }
}
