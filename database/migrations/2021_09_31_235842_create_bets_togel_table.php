<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTogelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets_togel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('togel_game_id')->comment('column id in togel_game table');
            $table->unsignedBigInteger('constant_provider_togel_id')->comment('column id in constant_provider_togel table');
            $table->string('period', 11)->nullable();

            $table->unsignedTinyInteger('number_1')->default(null)->nullable();
            $table->unsignedTinyInteger('number_2')->default(null)->nullable();
            $table->unsignedTinyInteger('number_3')->default(null)->nullable();
            $table->unsignedTinyInteger('number_4')->default(null)->nullable();
            $table->unsignedTinyInteger('number_5')->default(null)->nullable();
            $table->unsignedTinyInteger('number_6')->default(null)->nullable();
            
            $table->enum('tebak_as_kop_kepala_ekor', ['as', 'kop', 'kepala', 'ekor'])->default(null)->nullable()->comment('colok dan 5050');
            $table->enum('tebak_besar_kecil', ['besar', 'kecil'])->default(null)->nullable()->comment('5050 dan lain-lain');
            $table->enum('tebak_genap_ganjil', ['genap', 'ganjil'])->default(null)->nullable()->comment('5050 dan lain-lain');
            $table->enum('tebak_tengah_tepi', ['tengah', 'tepi'])->default(null)->nullable()->comment('5050 dan lain-lain');

            $table->enum('tebak_depan_tengah_belakang', ['depan', 'tengah', 'belakang'])->default(null)->nullable()->comment('5050 dan lain-lain');
            $table->enum('tebak_mono_stereo', ['mono', 'stereo'])->default(null)->nullable()->comment('5050');
            $table->enum('tebak_kembang_kempis_kembar', ['kembang', 'kempis', 'kembar'])->default(null)->nullable()->comment('5050');
            

            $table->unsignedBigInteger('tebak_shio')->default(null)->nullable()->comment('lain-lain');


            $table->boolean('win_lose_status')->default(0)->comment('1 = win');
            $table->unsignedBigInteger('togel_results_number_id')->default(null)->nullable()->comment('column id in togel_results_number table');
            
            $table->decimal('win_nominal', 13, 2)->nullable()->comment('nominal win');
            $table->decimal('bet_amount', 13, 2)->nullable()->comment('nominal bet');
            $table->unsignedBigInteger('togel_setting_game_id')->comment('column id in togel_setting_game table ');
            $table->decimal('discount_kei_amount_result', 13,2)->default(0)->comment('nominal tax/discount');
            $table->decimal('tax_amount', 13, 2)->nullable()->comment('nominal tax');
            $table->decimal('pay_amount', 13, 2)->nullable()->comment('nominal pay after deduction/tax');

            $table->decimal('buangan_before_submit', 13,2)->default(0.0)->comment('bet nominal sebelum discount/kei');
            $table->decimal('buangan_after_submit', 13,2)->default(0.0)->comment('bet nominal sebelum discount/kei');
            $table->decimal('buangan_terpasang', 13,2)->default(0.0)->comment('bet nominal sebelum discount/kei');
            $table->boolean('is_bets_buangan')->default(false)->comment('true = jika bet_amount > limit_buang');
            $table->boolean('is_bets_buangan_terpasang')->default(false)->comment('true = jika sudah terpasang');
            $table->dateTime('buangan_terpasang_date')->default(null);
            $table->unsignedBigInteger('buangan_terpasang_by')->default(null)->comment('id column in users table');

            $table->unsignedBigInteger('created_by')->comment('column id in users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('column id in users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('column id in users table');
            $table->timestamp('created_at')->comment('date when row was created');
            $table->timestamp('updated_at')->nullable()->comment('date when row was updated');
            $table->timestamp('deleted_at')->nullable()->comment('date when row was deleted');

            $table->index(['togel_game_id', 'created_by', 'tebak_shio']);
            
            $table->foreign('constant_provider_togel_id')->references('id')->on('constant_provider_togel');
            $table->foreign('togel_game_id')->references('id')->on('togel_game');
            $table->foreign('togel_setting_game_id')->references('id')->on('togel_setting_game');
            $table->foreign('created_by')->references('id')->on('members');

            $table->foreign('tebak_shio')->references('id')->on('togel_shio_name');
            $table->foreign('togel_results_number_id')->references('id')->on('togel_results_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets_togel');
    }
}
