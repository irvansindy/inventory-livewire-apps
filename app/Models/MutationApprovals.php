<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutationApprovals extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutation_approvals';

    protected $fillable = [
        'mutationId',
        'userId',
        'status',
        'comment',
        'signature',
    ];

    public function mutation()
    {
        return $this->hasOne(Mutations::class, 'id', 'mutationId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
