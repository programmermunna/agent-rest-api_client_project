<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTogelHistoryTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets_togel_history_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bets_togel_id')->comment('column id in bets_togel');
            $table->string('pasaran', 50)->comment('name_initial and period in constant_provider_togel table');
            $table->string('bet_id', 255)->comment('column id in bets_togel table');
            $table->text('description')->comment('bet details');
            $table->decimal('debit', 13,2)->default(0)->comment('the amount of pay_amount if the member loses');
            $table->decimal('kredit', 13,2)->default(0)->comment('the total to be paid to the member');
            $table->decimal('balance', 13,2)->default(0)->comment('total credit member');

            $table->unsignedBigInteger('created_by')->comment('column id in users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('column id in users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('column id in users table');
            $table->timestamp('created_at')->comment('date when row was created');
            $table->timestamp('updated_at')->nullable()->comment('date when row was updated');
            $table->timestamp('deleted_at')->nullable()->comment('date when row was deleted');
            $table->index(['bets_togel_id']);

            $table->foreign('bets_togel_id')->references('id')->on('bets_togel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets_togel_history_transaksi');
    }
}
