<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'offices';

    protected $fillable = [
        'officeName',
        'officeAddress',
    ];

    protected $hidden = [];
    
}
