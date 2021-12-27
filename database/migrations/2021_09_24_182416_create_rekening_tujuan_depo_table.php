<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningTujuanDepoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening_tujuan_depo', function (Blueprint $table) {
            $table->id();
            $table->integer('rekening_id_tujuan_depo1')->nullable();
            $table->integer('rekening_id_tujuan_depo2')->nullable();
            $table->integer('rekening_id_tujuan_depo3')->nullable();
            $table->integer('rekening_id_tujuan_depo4')->nullable();
            $table->integer('rekening_id_tujuan_depo5')->nullable();
            $table->integer('rekening_id_tujuan_depo6')->nullable();
            $table->integer('rekening_id_tujuan_depo7')->nullable();
            $table->integer('rekening_id_tujuan_depo8')->nullable();
            $table->integer('rekening_id_tujuan_depo9')->nullable();
            $table->integer('rekening_id_tujuan_depo10')->nullable();
            $table->integer('rekening_id_tujuan_depo11')->nullable();
            $table->integer('rekening_id_tujuan_depo12')->nullable();
            $table->integer('rekening_id_tujuan_depo13')->nullable();
            $table->integer('rekening_id_tujuan_depo14')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('members', function (Blueprint $table) {
            $table->string('rekening_tujuan_depo_id')->nullable()->after('credit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekening_tujuan_depo');
    }
}
