<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryLoanDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory_loan_details';

    protected $fillable = [
        'loanId',
        'productInventoryId',
    ];

    protected $hidden = [];

    public function inventoryLoan()
    {
        return $this->hasOne(InventoryLoan::class, 'id', 'loanId');
    }

    public function productInventory()
    {
        return $this->hasOne(ProductInventory::class, 'id', 'productInventaryId');
    }
}
