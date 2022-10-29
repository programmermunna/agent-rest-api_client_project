<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusFreebetModel extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'bonus_freebet';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'min_depo',
        'turnover_x',
        'turnover_amount',
        'info',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
