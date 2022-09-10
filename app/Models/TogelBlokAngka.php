<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TogelBlokAngka extends Model
{
    //
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'togel_blok_angka';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'constant_provider_togel_id', 'period', 'number_1', 'number_2', 'number_3', 'number_4', 'number_5', 'number_6', 'game', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function constant_provider_togel()
    {
        return $this->belongsTo(ConstantProviderTogelModel::class, 'constant_provider_togel_id', 'id');
    }

}
