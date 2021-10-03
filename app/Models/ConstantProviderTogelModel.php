<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstantProviderTogelModel extends Model
{
    
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'constant_provider_togel'; 
}
