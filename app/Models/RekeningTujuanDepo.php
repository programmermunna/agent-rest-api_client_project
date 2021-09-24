<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekeningTujuanDepo extends Model
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
    protected $table = 'rekening_tujuan_depo';
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
        'rekening_id_tujuan_depo1',
        'rekening_id_tujuan_depo2',
        'rekening_id_tujuan_depo3',
        'rekening_id_tujuan_depo4',
        'rekening_id_tujuan_depo5',
        'rekening_id_tujuan_depo6',
        'rekening_id_tujuan_depo7',
        'rekening_id_tujuan_depo8',
        'rekening_id_tujuan_depo9',
        'rekening_id_tujuan_depo10',
        'rekening_id_tujuan_depo11',
        'rekening_id_tujuan_depo12',
        'rekening_id_tujuan_depo13',
        'rekening_id_tujuan_depo14',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}
