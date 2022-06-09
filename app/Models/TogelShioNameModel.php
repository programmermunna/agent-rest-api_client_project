<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class TogelShioNameModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'togel_shio_name';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name'

        , 'created_by'
        , 'updated_by'
        , 'deleted_by'

        , 'created_at'
        , 'updated_at'
        , 'deleted_at'
    ];

    public function togel_shio_number()
    {
        return $this->hasMany(TogelShioNumberModel::class, 'togel_shio_name_id', 'id');
    }

    public function bets_togel()
    {
        return $this->hasMany(BetsTogelModel::class, 'tebak_shio', 'id');
    }

    public function togel_setting_game()
    {
        return $this->hasMany(TogelSettingGameModel::class, 'togel_shio_name_id', 'id');
    }
}



