<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebSiteContent extends Model
{
    use SoftDeletes;

    protected $table = 'website_contents';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'slug',
        'contents',
        'type',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
