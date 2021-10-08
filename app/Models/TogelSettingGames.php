<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TogelSettingGames extends Model
{
	//

	use SoftDeletes;

	protected $connection = 'mysql';

	protected $table = 'togel_setting_game';


	public $timestamps = false;

	protected $dates = ['deleted_at'];

	protected $fillable = [

		'constant_provider_togel_id', 'togel_game_id', 'togel_shio_name_id', 'min_bet', 'max_bet', 'win_x'

		// -- 4D	
		, 'max_bet_4d', 'win_4d_x', 'disc_4d', 'limit_buang_4d', 'limit_total_4d'


		// -- 3D
		, 'max_bet_3d', 'win_3d_x', 'disc_3d', 'limit_buang_3d', 'limit_total_3d'

		// -- 2D
		, 'max_bet_2d', 'win_2d_x', 'disc_2d', 'limit_buang_2d', 'limit_total_2d'

		// -- 2DD
		, 'max_bet_2d_depan', 'win_2d_depan_x', 'disc_2d_depan', 'limit_buang_2d_depan', 'limit_total_2d_depan'

		// -- 2DD
		, 'max_bet_2d_tengah', 'win_2d_tengah_x', 'disc_2d_tengah', 'limit_buang_2d_tengah', 'limit_total_2d_tengah'

		// -- colok bebas
		, 'disc', 'limit_buang', 'limit_total'


		// -- colok macau & naga            
		, 'win_2_digit', 'win_3_digit', 'win_4_digit'

		// -- colok jitu            
		, 'win_as', 'win_kop', 'win_kepala', 'win_ekor'

		// -- 50-50 special            
		, 'kei_as_ganjil', 'kei_as_genap', 'kei_as_besar', 'kei_as_kecil', 'kei_kop_ganjil', 'kei_kop_genap', 'kei_kop_besar', 'kei_kop_kecil', 'kei_kepala_ganjil', 'kei_kepala_genap', 'kei_kepala_besar', 'kei_kepala_kecil', 'kei_ekor_ganjil', 'kei_ekor_genap', 'kei_ekor_besar', 'kei_ekor_kecil'


		// -- 50-50 umum & lain-lain dasar
		, 'kei_besar', 'kei_kecil', 'kei_genap', 'kei_ganjil', 'kei_tengah', 'kei_tepi'


		// -- 50-50 kombinasi            
		, 'belakang_kei_mono', 'belakang_kei_stereo', 'belakang_kei_kembang', 'belakang_kei_kempis', 'belakang_kei_kembar', 'tengah_kei_mono', 'tengah_kei_stereo', 'tengah_kei_kembang', 'tengah_kei_kempis', 'tengah_kei_kembar', 'depan_kei_mono', 'depan_kei_stereo', 'depan_kei_kembang', 'depan_kei_kempis', 'depan_kei_kembar', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
	];


	public function togel_game()
	{
		return $this->belongsTo(TogelGameModel::class, 'togel_category_game_id', 'id');
	}

	public function constant_provider_togel()
	{
		return $this->belongsTo(ConstantProviderTogelModel::class, 'constant_provider_togel_id', 'id');
	}

	public function togel_shio_name()
	{
		return $this->belongsTo(TogelShioNameModel::class, 'togel_shio_name_id', 'id');
	}

	/**
	 * Get Scope For 50 - 50 
	 * @param Builder $query 
	 * @param int $type
	 * @param int $provider
	 */
	public function scopeFifty(Builder $query, array $type, int $provider): Builder
	{
		return $query
			->join('togel_game', 'togel_game.id', '=', 'togel_setting_game.togel_game_id')
			->where("constant_provider_togel_id", '=', $provider)
			->whereIn('togel_game_id', $type)
			->select([
				'togel_game.name as game_name',
				'constant_provider_togel_id',
				'togel_game_id',
				'togel_shio_name_id',
				'min_bet',
				'max_bet',
				'kei_as_ganjil',
				'kei_as_genap',
				'kei_as_besar',
				'kei_as_kecil',
				'kei_kop_ganjil',
				'kei_kop_genap',
				'kei_kop_besar',
				'kei_kop_kecil',
				'kei_kepala_ganjil',
				'kei_kepala_genap',
				'kei_kepala_besar',
				'kei_kepala_kecil',
				'kei_ekor_ganjil',
				'kei_ekor_genap',
				'kei_ekor_besar',
				'kei_ekor_kecil',
				'kei_besar',
				'kei_kecil',
				'kei_genap',
				'kei_ganjil',
				'kei_tengah',
				'kei_tepi', 
				'belakang_kei_mono',
				'belakang_kei_stereo',
				'belakang_kei_kembang',
				'belakang_kei_kempis',
				'belakang_kei_kembar',
				'tengah_kei_mono',
				'tengah_kei_stereo',
				'tengah_kei_kembang',
				'tengah_kei_kempis',
				'tengah_kei_kembar',
				'depan_kei_mono',
				'depan_kei_stereo',
				'depan_kei_kembang',
				'depan_kei_kempis',
				'depan_kei_kembar',
		]);
	}

	/**
	 * Get Scope Colok Jitu = 
	 * @param Builder $query 
	 * @param int $type
	 * @param int $provider
	 */
	public function scopeColokJitu(Builder $query, $type , int $provider) : Builder
	{
		return $query
			->join('togel_game' , 'togel_game.id' , '=' , 'togel_setting_game.togel_game_id')
			->whereIn('togel_game_id', $type)
		    ->where('constant_provider_togel_id' , $provider)
			->select([
				'togel_game.name as game_name',
				'togel_game.name',
				'disc',
			]);
	}

	/**
	 * Get Scope Colok Jitu = 
	 * @param Builder $query 
	 * @param int $type
	 * @param int $provider
	 */
	public function scopeNormal(Builder $query, array $type, int $provider): Builder
	{
		return $query
			->join('togel_game' , 'togel_game.id' , '=' , 'togel_setting_game.togel_game_id')
			->where("constant_provider_togel_id", '=', $provider)
			->whereIn('togel_game_id', $type)
			->select([
				'togel_game.name as game_id',
				'constant_provider_togel_id', 'togel_game_id', 'togel_shio_name_id', 'min_bet', 'max_bet', 'win_x'
				// -- 4D	
				, 'max_bet_4d', 'win_4d_x', 'disc_4d', 'limit_buang_4d', 'limit_total_4d'
				// -- 3D
				, 'max_bet_3d', 'win_3d_x', 'disc_3d', 'limit_buang_3d', 'limit_total_3d'
				// -- 2D
				, 'max_bet_2d', 'win_2d_x', 'disc_2d', 'limit_buang_2d', 'limit_total_2d'
				// -- 2DD
				, 'max_bet_2d_depan', 'win_2d_depan_x', 'disc_2d_depan', 'limit_buang_2d_depan', 'limit_total_2d_depan'
				// -- 2DD
				, 'max_bet_2d_tengah', 'win_2d_tengah_x', 'disc_2d_tengah', 'limit_buang_2d_tengah', 'limit_total_2d_tengah'
				// -- colok bebas
				, 'disc', 'limit_buang', 'limit_total'
			]);
	}


}
