<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTesting extends Model
{
    use HasFactory;

    protected $table = 'account_testings';

    protected $fillable = [
        'account',
        'username',
    ];

    protected $hidden = [];
}
