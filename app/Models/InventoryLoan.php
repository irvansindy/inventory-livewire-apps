<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class InventoryLoan extends Model
{
    use HasFactory, SoftDeletes, AutoNumberTrait;

    protected $table = 'inventory_loans';

    protected $fillable = [
        'loanCode',
        'loanStartDate',
        'loanEndDate',
        'loanerUserId',
        'officerUserId',
        'status',
        'loanDescription',
    ];

    protected $hidden = [];

    public function inventoryLoanDetails()
    {
        return $this->hasMany(InventoryLoanDetails::class, 'loanId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'loanerUserId');
    }

    public function location()
    {
        return $this->belongsTo(Locations::class, 'officerUserId');
    }

    public function getAutoNumberOptions()
    {
        return [
            'loanCode' => [
                'format' => function () {
                    return 'LN/' . date('Ymd') . '/?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 4, // The number of digits in the autonumber
            ],
        ];
    }
}
