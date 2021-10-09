<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TogelDreamsBookModel extends Model
{
	use SoftDeletes;

	protected $connection = 'mysql';

	protected $table = 'togel_dreams_book';


	public $timestamps = false;

	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'type', 'combination_number', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at']; 
}
