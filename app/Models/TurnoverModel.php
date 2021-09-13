<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurnoverModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'turnover';


    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'is_turnover1',
        'is_turnover2',
        'is_turnover3',
        'is_turnover4',
        'is_turnover5',
        'is_turnover6',
        'is_turnover7',
        'is_turnover8',
        'is_turnover9',
        'is_turnover10',
        'is_turnover11',
        'is_turnover12',
        'is_turnover13',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
