<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $table = 'cash_registers';

    protected $fillable = ['date', 'amount', 'user_id'];

    protected $casts = [
        'date' => 'date',
    ];
}
