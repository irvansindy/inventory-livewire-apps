<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procurement_types';

    protected $fillable = [
        'procurementType',
    ];

    protected $hidden = [];
}
