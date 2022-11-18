<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTransactionModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jobs_transaction';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'payload',
        'Processed_at_member_api',
        'Proccessed_at_agent_api',
    ];
}
