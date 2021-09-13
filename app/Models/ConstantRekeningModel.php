<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstantRekeningModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

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
    protected $table = 'constant_rekening';
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
      'name',
      'is_bank',  // 1=bank, 0=NonBank
      'status',   // 1=online, 2=offline, 3=gangguan
      'logo',
      'created_by',
      'created_at',
      'updated_by',
      'updated_at',
      'deleted_by',
      'deleted_at',
    ];

    public function rekMemberModel()
    {
        return $this->hasMany(RekMemberModel::class, 'constant_member_id', 'id');
    }

    public function scopeNonBank($query)
    {
        return $query->where('is_bank', false);
    }

    public function rekenings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RekeningModel::class, 'constant_rekening_id');
    }
}
