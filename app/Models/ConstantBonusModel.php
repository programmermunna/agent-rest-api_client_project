<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstantBonusModel extends Model
{

    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'constant_bonus';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    // protected $fillable = [
    // ];
}
