<?php

namespace App\Models;

use App\Events\CreateDepositEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $dates = ['deleted_at'];

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'deposit';

    protected $appends = ['type'];

    public $timestamps = true;

    /**
    * The attributes that are not mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];

    protected function getTypeAttribute()
    {
        return 'deposit';
    }

    public function userFront()
    {
        # where user id di 'deposit' = user id front 'users'
        return $this->belongsTo('App\Models\UserFrontMemberPanelModel', 'front_user_id', 'id');
    }

    public function tujuanRekening()
    {
        # where conts rek id di 'deposit' = id di 'constant_rekening'
        return $this->belongsTo('App\Models\RekeningModel', 'rekening_id', 'id');
    }
}
