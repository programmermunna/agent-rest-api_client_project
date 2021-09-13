<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnoverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnover', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_turnover1')->default(false)->comment('1 = get turnover 1');
            $table->boolean('is_turnover2')->default(false)->comment('1 = get turnover 2');
            $table->boolean('is_turnover3')->default(false)->comment('1 = get turnover 3');
            $table->boolean('is_turnover4')->default(false)->comment('1 = get turnover 4');
            $table->boolean('is_turnover5')->default(false)->comment('1 = get turnover 5');
            $table->boolean('is_turnover6')->default(false)->comment('1 = get turnover 6');
            $table->boolean('is_turnover7')->default(false)->comment('1 = get turnover 7');
            $table->boolean('is_turnover8')->default(false)->comment('1 = get turnover 8');
            $table->boolean('is_turnover9')->default(false)->comment('1 = get turnover 9');
            $table->boolean('is_turnover10')->default(false)->comment('1 = get turnover 10');
            $table->boolean('is_turnover11')->default(false)->comment('1 = get turnover 11');
            $table->boolean('is_turnover12')->default(false)->comment('1 = get turnover 12');
            $table->boolean('is_turnover13')->default(false)->comment('1 = get turnover 13');

            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnover');
    }
}
