<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class TurnoverMember extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'deposit_id',
        'withdraw_id',
        'member_id',
        'constant_bonus_id',
        'turnover_target',
        'turnover_member',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
