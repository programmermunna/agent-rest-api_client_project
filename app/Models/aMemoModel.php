<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class aMemoModel extends Model
{
    use SoftDeletes;

    protected $table = 'amemo';

    public $timestamps = true;

    // protected $dates = ['deleted_at'];
    

    protected $guarded = ['id'];

    protected $fillable = [
        'member_id',
        'subject',
        'content',
        // 'type',
        'is_read',
        'member_id',
        'sender_id',
        'created_by',
        'created_at',
        // 'updated_by',
        'updated_at',
        // 'deleted_by',
        'deleted_at',
    ];
}