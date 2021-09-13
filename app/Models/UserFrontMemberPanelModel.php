<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFrontMemberPanelModel extends Model
{
    use SoftDeletes;

    protected $connection = 'dbMemberPanel';

    public function memberConsRek(){
      # where id di 'constant_rekening' = const id di 'users' front
      return $this->belongsTo('App\Models\ConstantRekeningModel', 'constant_rekening_id', 'id');
    }
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [
    //     'deleted_at',
    // ];

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public $timestamps = true;
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'type',
        'username',
        'constant_rekening_id',
        'bank_account_name',
        'email',
        'email_verified_at',
        'password',
        'password_changed_at',
        'active',
        // 'web_id', #cuma dipakai di robocop.
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'provider',
        'provider_id',
    ];
}
