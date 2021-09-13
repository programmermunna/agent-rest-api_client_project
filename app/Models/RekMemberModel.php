<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RekMemberModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'rek_member';


    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'constant_rekening_id',
        'rekening_id',
        'member_id',
        'username_member',
        'is_depo',
        'is_wd',
        'is_default',
        'nama_rekening',
        'nomor_rekening',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function members()
    {
        return $this->belongsTo(MembersModel::class, 'username_member','username');
    }

//    public function constantRekening()
//    {
//        return $this->belongsTo(ConstantRekeningModel::class, 'constant_rekening_id','id');
//    }

    public function rekening()
    {
        return $this->belongsTo(RekeningModel::class, 'rekening_id','id');
    }
}
