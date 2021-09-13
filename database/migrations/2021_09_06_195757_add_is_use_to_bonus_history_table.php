<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUseToBonusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bonus_history', function (Blueprint $table) {
            $table->integer('free_bet_id')->after('id');
            $table->boolean('is_use')->nullalbe()->after('id')->comment('1 = get freebet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bonus_history', function (Blueprint $table) {
            //
        });
    }
}
