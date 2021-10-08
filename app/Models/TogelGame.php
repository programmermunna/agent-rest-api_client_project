<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TogelGame extends Model
{
  use SoftDeletes;

  protected $connection = 'mysql';

  protected $table = 'togel_game';


  public $timestamps = false;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'name', 'togel_category_game_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
  ];

  public function bets_togel()
  {
    return $this->hasMany(BetsTogelModel::class, 'togel_game_id', 'id');
  }

  public function togel_category_game()
  {
    return $this->belongsTo(TogelCategoryGameModel::class, 'togel_category_game_id', 'id');
  }

  public function togel_setting_game()
  {
    return $this->hasMany(TogelSettingGameModel::class, 'togel_game_id', 'id');
  }
}
