<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WinLoseAllMember extends Model
{
    use SoftDeletes;

    protected $table = 'win_lose_all';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'game_id',
        'bet_id',
        'bet_amount',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
