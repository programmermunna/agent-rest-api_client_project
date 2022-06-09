<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BetsTogelQuotaLimitModel extends Model
{
    protected $connection = 'mysql';

    protected $table = 'bets_togel_quota_limit';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id'
        , 'togel_game_id'
        , 'constant_provider_togel_id'
        , 'number_1'
        , 'number_2'
        , 'number_3'
        , 'number_4'
        , 'number_5'
        , 'number_6'
        , 'tebak_as_kop_kepala_ekor'
        , 'tebak_besar_kecil'
        , 'tebak_genap_ganjil'
        , 'tebak_tengah_tepi'
        , 'tebak_depan_tengah_belakang'
        , 'tebak_mono_stereo'
        , 'tebak_kembang_kempis_kembar'
        , 'tebak_shio'
        , 'sisa_quota'
        , 'created_by'
        , 'updated_by'
        , 'deleted_by'
        , 'created_at'
        , 'updated_at'
        , 'deleted_at'
    ];

    public function togel_game()
    {
        return $this->belongsTo(TogelGameModel::class, 'togel_game_id', 'id');
    }

    public function constant_provider_togel()
    {
        return $this->belongsTo(ConstantProviderTogelModel::class, 'constant_provider_togel_id', 'id');
    }

    public function tebak_shio()
    {
        return $this->belongsTo(TogelShioNameModel::class, 'tebak_shio', 'id');
    }
}
