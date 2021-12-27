<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('constant_provider_id')->nullable();
            $table->string('round_id', 40);
            $table->string('bet_id')->nullable();
            $table->decimal('bonus_daily_referal', 16, 2)->nullable()->default(0.00);
            $table->string('bet_name', 191)->nullable();
            $table->string('game', 191)->nullable();
            $table->string('game_id', 191);
            $table->text('deskripsi')->nullable();
            $table->decimal('win', 16, 2)->nullable()->default(0.00);
            $table->enum('type', ['Win', 'Lose']);
            $table->enum('game_info', ['fish', 'slot'])->nullable();
            $table->decimal('bet', 16, 2)->default(0.00);
            $table->decimal('credit', 16, 2)->nullable()->default(0.00);
            $table->decimal('player_wl', 16, 2)->nullable()->default(0.00);
            $table->string('url_detail')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('constant_provider_id')->references('id')->on('constant_provider');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets');
    }
}
