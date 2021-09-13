<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model
{
    use SoftDeletes;

    protected $table = 'app_settings';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'value',
        'type',
        'additional',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
