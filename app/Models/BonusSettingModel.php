<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusSettingModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bonus_setting';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'constant_bonus_id',
        'constant_provider_id',
        'judul',
        'value',
        'type',
        'min_lose',
        'max_lose',
        'min_rollingan',
        'max_rollingan',
        'hadiah',
        'min_depo',
        'max_depo',
        'bonus_amount',
        'max_bonus',
        'turnover_x',
        'turnover_amount',
        'info',
        'status_bonus',
        'durasi_bonus_promo',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
