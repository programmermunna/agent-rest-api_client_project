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
            $table->string('event');
            $table->string('jumlah')->comment('jumlah = type uang')->nullalbe();
            $table->string('hadiah')->comment('hadiah = type barang')->nullalbe();
            $table->enum('type', ['uang', 'barang']);
            $table->integer('created_by')->nullalbe();
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
