<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class Mutations extends Model
{
    use HasFactory, SoftDeletes, AutoNumberTrait;

    protected $table = 'mutations';

    protected $fillable = [
        'mutationNumber',
        'mutationDate',
        'mutationDescription',
        'userId',
        'mutationStatus'
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function inventory()
    {
        return $this->belongsTo(ProductInventory::class, 'inventoryId');
    }

    public function mutationFrom()
    {
        return $this->hasOne(MutationFroms::class, 'mutationId');
    }

    public function mutationTo()
    {
        return $this->hasOne(MutationTo::class, 'mutationId');
    }

    public function mutationDetails()
    {
        return $this->hasMany(MutationDetails::class, 'mutationId');
    }

    public function getAutoNumberOptions()
    {
        return [
            'mutationNumber' => [
                'format' => function () {
                    return 'MUTT/' . date('ymd') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 4, // The number of digits in the autonumber
            ],
        ];
    }
}
