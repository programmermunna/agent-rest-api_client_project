<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTogelSettingGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('togel_setting_game', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('constant_provider_togel_id')->comment('column id in constant_provider_togel table');
            $table->unsignedBigInteger('togel_game_id')->nullable()->default(null)->comment('column id in togel_game');
            $table->unsignedBigInteger('togel_shio_name_id')->nullable()->default(null)->comment('column id in togel_shio_name');

            $table->decimal('min_bet', 13, 2)->nullable()->default(0)->comment('minimal bet');
            $table->decimal('max_bet', 13, 2)->nullable()->default(0)->comment('maksimal bet');
            $table->decimal('win_x', 13, 2)->nullable()->default(0)->comment('win x bet');

            // -- 4D	
            $table->decimal('max_bet_4d', 13,2)->default(0)->comment('max bet 4d');
            $table->decimal('win_4d_x', 13,2)->default(0)->comment('win 4d x');
            $table->decimal('disc_4d', 8,2)->default(0)->comment('discount 4d');
            $table->decimal('limit_buang_4d', 13,2)->default(0)->comment('limit buang 4d');
            $table->decimal('limit_total_4d', 13,2)->default(0)->comment('limit total 4d');


            // -- 3D
            $table->decimal('max_bet_3d', 13,2)->default(0)->comment('max bet 3d');
            $table->decimal('win_3d_x', 13,2)->default(0)->comment('win 3d x');
            $table->decimal('disc_3d', 8,2)->default(0)->comment('discount 3d');
            $table->decimal('limit_buang_3d', 13,2)->default(0)->comment('limit buang 3d');
            $table->decimal('limit_total_3d', 13,2)->default(0)->comment('limit total 3d');

            // -- 2D
            $table->decimal('max_bet_2d', 13,2)->default(0)->comment('max bet 2d');
            $table->decimal('win_2d_x', 13,2)->default(0)->comment('win 2d x');
            $table->decimal('disc_2d', 8,2)->default(0)->comment('discount 2d');
            $table->decimal('limit_buang_2d', 13,2)->default(0)->comment('limit buang 2d');
            $table->decimal('limit_total_2d', 13,2)->default(0)->comment('limit total 2d');

            // -- 2DD
            $table->decimal('max_bet_2d_depan', 13,2)->default(0)->comment('max bet 2d depan');
            $table->decimal('win_2d_depan_x', 13,2)->default(0)->comment('win 2d depan x');
            $table->decimal('disc_2d_depan', 8,2)->default(0)->comment('discount 2d depan');
            $table->decimal('limit_buang_2d_depan', 13,2)->default(0)->comment('limit buang 2d depan');
            $table->decimal('limit_total_2d_depan', 13,2)->default(0)->comment('limit total 2d depan');

            // -- 2DD
            $table->decimal('max_bet_2d_tengah', 13,2)->default(0)->comment('max bet 2d tengah');
            $table->decimal('win_2d_tengah_x', 13,2)->default(0)->comment('win 2d tengah x');
            $table->decimal('disc_2d_tengah', 8,2)->default(0)->comment('discount 2d tengah');
            $table->decimal('limit_buang_2d_tengah', 13,2)->default(0)->comment('limit buang 2d tengah');
            $table->decimal('limit_total_2d_tengah', 13,2)->default(0)->comment('limit total 2d tengah');

            // -- colok bebas
            $table->decimal('disc', 13, 2)->nullable()->default(0)->comment('discount');
            $table->decimal('limit_buang', 13, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('limit_total', 13, 2)->nullable()->default(0)->comment('tax percent');


            // -- colok macau & naga            
            $table->decimal('win_2_digit', 13, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('win_3_digit', 13, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('win_4_digit', 13, 2)->nullable()->default(0)->comment('tax percent');

            // -- colok jitu            
            $table->decimal('win_as', 13, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('win_kop', 13, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('win_kepala', 13, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('win_ekor', 13, 2)->nullable()->default(0)->comment('tax percent');

            // -- 50-50 special            
            $table->decimal('kei_as_ganjil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_as_genap', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_as_besar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_as_kecil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kop_ganjil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kop_genap', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kop_besar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kop_kecil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kepala_ganjil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kepala_genap', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kepala_besar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kepala_kecil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_ekor_ganjil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_ekor_genap', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_ekor_besar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_ekor_kecil', 8, 2)->nullable()->default(0)->comment('tax percent');


            // -- 50-50 umum & lain-lain dasar
            $table->decimal('kei_besar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_kecil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_genap', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_ganjil', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_tengah', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('kei_tepi', 8, 2)->nullable()->default(0)->comment('tax percent');


            // -- 50-50 kombinasi            
            $table->decimal('belakang_kei_mono', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('belakang_kei_stereo', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('belakang_kei_kembang', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('belakang_kei_kempis', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('belakang_kei_kembar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('tengah_kei_mono', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('tengah_kei_stereo', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('tengah_kei_kembang', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('tengah_kei_kempis', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('tengah_kei_kembar', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('depan_kei_mono', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('depan_kei_stereo', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('depan_kei_kembang', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('depan_kei_kempis', 8, 2)->nullable()->default(0)->comment('tax percent');
            $table->decimal('depan_kei_kembar', 8, 2)->nullable()->default(0)->comment('tax percent');


            $table->unsignedBigInteger('created_by')->comment('column id in users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('column id in users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('column id in users table');
            $table->timestamp('created_at')->comment('date when row was created');
            $table->timestamp('updated_at')->nullable()->comment('date when row was updated');
            $table->timestamp('deleted_at')->nullable()->comment('date when row was deleted');

            $table->index(['togel_game_id', 'togel_shio_name_id']);   

            $table->foreign('constant_provider_togel_id')->references('id')->on('constant_provider_togel');
            $table->foreign('togel_game_id')->references('id')->on('togel_game');
            $table->foreign('togel_shio_name_id')->references('id')->on('togel_shio_name');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('togel_setting_game');
    }
}
