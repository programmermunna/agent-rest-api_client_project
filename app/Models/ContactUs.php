<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;

    protected $table = 'contact_us';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'contact_us',
        'user_name',
        'email',
        'destination',
        'message',
        'number',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
