<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class InventoryPlacement extends Model
{
    use HasFactory, SoftDeletes, AutoNumberTrait;

    protected $table = 'inventory_placements';

    protected $fillable = [
        'placementNumber',
        'placementDate',
        'userId',
        'officeId',
        'placementDescription',
        'placementType',
    ];

    protected $hidden = [];

    public function placementDetails()
    {
        return $this->hasMany(InventoryPlacementDetails::class, 'placementId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    // public function location()
    // {
    //     return $this->belongsTo(Locations::class, 'locationId');
    // }

    public function office()
    {
        return $this->belongsTo(Office::class, 'officeId');
    }

    public function getAutoNumberOptions()
    {
        return [
            'placementNumber' => [
                'format' => function () {
                    return 'PLI/' . date('Ymd') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 4, // The number of digits in the autonumber
            ],
        ];
    }

}