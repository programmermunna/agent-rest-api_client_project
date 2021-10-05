<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstantProviderTogelModel extends Model
{
    
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'constant_provider_togel';
	
	/**
	 * For Each Provider have many result number 
	 */
	public function resultNumber() : HasMany
	{
		return $this->hasMany(TogelResultNumberModel::class , 'constant_provider_togel_id');
	}
}
