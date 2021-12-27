<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_history', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_delete')->comment('1 = event freebet deleted');
            $table->boolean('is_use')->comment('1 = get freebet');
            $table->integer('free_bet_id')->nullable();
            $table->integer('constant_bonus_id');
            $table->string('jumlah')->comment('jumlah = type uang');
            $table->string('hadiah')->comment('hadiah = type barang');
            $table->enum('type', ['uang', 'barang']);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonus_history');
    }
}
