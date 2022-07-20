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
    

    public function user()
    {
        return $this->hasMany(User::class, 'officeId');
    }

    public function productInventory()
    {
        return $this->hasMany(ProductInventory::class, 'officeId');
    }

    public function mutationFrom()
    {
        return $this->hasMany(MutationFrom::class, 'officeId');
    }
}
