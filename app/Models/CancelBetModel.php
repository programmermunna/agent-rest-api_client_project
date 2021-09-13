<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelBetModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'cancel_bet';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cancel_id',
        'bet_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
