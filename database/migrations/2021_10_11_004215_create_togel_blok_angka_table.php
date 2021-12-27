<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTogelBlokAngkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('togel_blok_angka', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('constant_provider_togel_id')->comment('column id in constant_provider_togel table');
            $table->string('number_1', 1)->default(null)->nullable();
            $table->string('number_2', 1)->default(null)->nullable();
            $table->string('number_3', 1)->default(null)->nullable();
            $table->string('number_4', 1)->default(null)->nullable();
            $table->string('number_5', 1)->default(null)->nullable();
            $table->string('number_6', 1)->default(null)->nullable();
            $table->string('game', 50)->comment('type of game');
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
        Schema::dropIfExists('togel_blok_angka');
    }
}
