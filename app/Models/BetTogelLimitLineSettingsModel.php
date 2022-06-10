<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BetTogelLimitLineSettingsModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'bet_togel_limit_line_settings';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id'
        , 'constant_provider_togel_id'
        , 'limit_2d_tengah'
        , 'limit_2d_depan'
        , 'limit_2d'
        , 'limit_3d'
        , 'limit_4d'
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
