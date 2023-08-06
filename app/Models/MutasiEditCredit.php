<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutasiEditCredit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutasi_edit_credit';
}
