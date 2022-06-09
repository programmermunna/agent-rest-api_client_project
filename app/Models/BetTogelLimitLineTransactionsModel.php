<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetTogelLimitLineTransactionsModel extends Model
{
    protected $connection = 'mysql';

    protected $table = 'bet_togel_limit_line_transactions';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id'
        , 'constant_provider_togel_id'
        , 'number_1'
        , 'number_2'
        , 'number_3'
        , 'number_4'
        , 'number_5'
        , 'number_6'
        , 'member_id'
        , 'created_by'
        , 'updated_by'
        , 'deleted_by'
        , 'created_at'
        , 'updated_at'
        , 'deleted_at'
    ];

    public function constant_provider_togel()
    {
        return $this->belongsTo(ConstantProviderTogelModel::class, 'constant_provider_togel_id', 'id');
    }

    public function members()
    {
        return $this->belongsTo(MembersModel::class, 'member_id', 'id');
    }
}
