<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutationTo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutation_tos';

    protected $fillable = [
        'mutationId',
        'officeId',
    ];

    protected $hidden = [];
}
