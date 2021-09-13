<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotonganProviderNonBankModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'potongan_provider_non_bank';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'rek_member_id',
        'event',
        'constant_rekening_id',
        'jumlah',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
