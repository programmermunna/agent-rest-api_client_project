<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusTurnoverModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'bonus_turnover';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'judul',
        'value',
        'type',
        'hadiah',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
