<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutationDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'mutation_details';

    protected $fillable = [
        'mutationId',
        'productInventoryId',
    ];

    protected $hidden = [];

    public function productInventory()
    {
        return $this->hasOne(ProductInventory::class, 'id', 'productInventoryId');
    }

    public function mutation()
    {
        return $this->belongsTo(Mutations::class, 'mutationId');
    }
}
