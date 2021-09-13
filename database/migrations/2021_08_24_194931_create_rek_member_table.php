<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rek_member', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('constant_rekening_id')->nullable();
            $table->integer('rekening_id')->nullable();
            $table->string('username_member', 191);
            $table->string('nomor_rekening', 191);
            $table->string('nama_rekening', 191);
            $table->boolean('is_depo')->default(false)->comment('1 = rekening member untuk deposit');
            $table->boolean('is_wd')->default(false)->comment('1 = rekening member untuk wd');
            $table->boolean('is_default')->default(false)->comment('1 = is default untuk wd');
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
        Schema::dropIfExists('rek_member');
    }
}
