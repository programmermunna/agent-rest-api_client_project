<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositWithdrawHistory extends Model
{
    use HasFactory;

    protected $table = 'deposit_withdraw_history';

    protected $fillable = [
        'deposit_id',
        'withdraw_id',
        'member_id',
        'status',
        'amount',
        'credit',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
