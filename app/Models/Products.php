<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;


class Products extends Model
{
    use HasFactory, SoftDeletes, AutoNumbertrait;

    protected $table = 'products';

    protected $fillable = [
        'productCode',
        'productName',
        'categoryId',
        'productDescription',
        'merk',
        'qty',
        'minimumStock',
    ];

    protected $hidden = [];

    public function categories()
    {
        return $this->hasOne(ProductCategories::class, 'id', 'categoryId');
    }
    
    public function inventories()
    {
        return $this->belongTo(ProductInventory::class, 'productId', 'id');
    }

    public function getAutoNumberOptions()
    {
        return [
            'productCode' => [
                'format' => function () {
                    return 'PRO/' . date('ym') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 4, // The number of digits in the autonumber
            ],
        ];
    }
}
