<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositModel extends Model
{
  // public const MIN_DEPOSIT_AMOUNT = 25000;

  use SoftDeletes;

  protected $connection = 'mysql';

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

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  //    protected $fillable = [
  //      'front_user_id',
  //      'rekening_id',
  //      'jumlah',
  //      'note',
  //      'is_claim',
  //      'approval_status',
  //      'approval_status_by',
  //      'approval_status_at',
  //      'created_by',
  //      'created_at',
  //      'updated_by',
  //      'updated_at',
  //      'deleted_by',
  //      'deleted_at',
  //    ];
}
