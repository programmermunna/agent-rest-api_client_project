<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMorphableToBetsTogelHistoryTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bets_togel_history_transaksi', function (Blueprint $table) {
            $table->string('model_type')->nullable();
            $table->string('model_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bets_togel_history_transaksi', function (Blueprint $table) {
            //
        });
    }
}
