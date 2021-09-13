<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class GamesModel extends Model
{
    use SoftDeletes;

    protected $table = 'games';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'game_name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
