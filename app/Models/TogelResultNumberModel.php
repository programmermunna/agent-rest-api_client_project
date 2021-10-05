<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TogelResultNumberModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'togel_results_number';

	// CONSTANT VALUE	
	public static $POOLS = ['SINGAPORE' , 'HONGKONG' , 'JINAN' , 'Sydney'];

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'result_date'
        , 'constant_provider_togel_id'
        , 'number_result_1'
        , 'number_result_2'
        , 'number_result_3'
        , 'number_result_4'
        , 'number_result_5'
        , 'number_result_6'
        , 'period'

        , 'created_by'
        , 'updated_by'
        , 'deleted_by'

        , 'created_at'
        , 'updated_at'
        , 'deleted_at'
    ];
	
	/**
	 * Get Relation From provider 
	 */
    public function TogelProvider() : BelongsTo
    {
        return $this->belongsTo(ConstantProviderTogelModel::class, 'constant_provider_togel_id', 'id');
    }
}

