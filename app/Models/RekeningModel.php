<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekeningModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    public function tujuanConsRek()
    {
        # where const rek id di 'rekening' = id di 'rekening'
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
    protected $table = 'rekening';
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
      'constant_rekening_id',
      'nama_rekening',
      'nomor_rekening',
      'user_banking',
      'password_banking',
      'keterangan',
      'nett',
      'is_bank',
      'is_default',
      'is_depo',
      'is_wd',
      'saldo_awal',
      'saldo_akhir',
      'koreksi', # update, plus, minus
      'jumlah_koreksi_balance',
      'deskripsi',
      'created_by',
      'created_at',
      'updated_by',
      'updated_at',
      'deleted_by',
      'deleted_at',
    ];

    public function constantRekening(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ConstantRekeningModel::class, 'constant_rekening_id');
    }

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MembersModel::class, 'rekening_id_tujuan_depo');
    }

    public function withdrawals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WithdrawModel::class, 'rekening_id');
    }

    public function deposits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DepositModel::class, 'rekening_id');
    }
}
