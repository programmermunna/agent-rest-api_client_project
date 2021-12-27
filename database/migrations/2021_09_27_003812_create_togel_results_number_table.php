<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTogelResultsNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('togel_results_number', function (Blueprint $table) {
            $table->id();
            $table->dateTime('result_date', $precision = 0)->comment('tanggal hasil');
            $table->unsignedBigInteger('constant_provider_togel_id')->comment('column id pada tabel constant_provider_togel');

            $table->unsignedTinyInteger('number_result_1')->default(null)->comment('hasil nomor 1');
            $table->unsignedTinyInteger('number_result_2')->default(null)->comment('hasil nomor 2');
            $table->unsignedTinyInteger('number_result_3')->default(null)->comment('hasil nomor 3');
            $table->unsignedTinyInteger('number_result_4')->default(null)->comment('hasil nomor 4');
            $table->unsignedTinyInteger('number_result_5')->default(null)->comment('hasil nomor 5');
            $table->unsignedTinyInteger('number_result_6')->default(null)->comment('hasil nomor 6');

            $table->string('period', 11)->nullable();
            $table->unsignedBigInteger('created_by')->comment('column id in users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('column id in users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('column id in users table');
            $table->timestamp('created_at')->comment('date when row was created');
            $table->timestamp('updated_at')->nullable()->comment('date when row was updated');
            $table->timestamp('deleted_at')->nullable()->comment('date when row was deleted');

            $table->index(['constant_provider_togel_id']);
            $table->foreign('constant_provider_togel_id')->references('id')->on('constant_provider_togel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('togel_results_number');
    }
}
