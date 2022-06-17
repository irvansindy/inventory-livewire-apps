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
        'inventoryId',
    ];

    protected $hidden = [];

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
