<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusHistoryReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'bonus_history_id',
        'constant_bonus_id',
        'name_bonus',
        'member_id',
        'member_username',
        'credit',
        'user_id',
        'user_username',
        'jumlah',
        'hadiah',
        'status',
        'created_by',
        'updated_by',
        'bonus_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
