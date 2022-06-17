<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutationFroms extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutation_froms';

    protected $fillable = [
        'mutationId',
        'locationId',
    ];

    protected $hidden = [];
}
