<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening', function (Blueprint $table) {
            $table->id();
            $table->integer('constant_rekening_id');
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('nama_rekening', 100)->nullable();
            $table->string('user_banking', 50)->nullable();
            $table->string('password_banking', 50)->nullable();
            $table->string('keterangan', 100)->nullable();
            $table->decimal('nett', 13, 2);
            $table->boolean('is_bank')->default(true)->comment('0 = non bank; 1 = bank');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_depo')->default(false)->comment('1 = rekening untuk deposit');
            $table->boolean('is_wd')->default(false)->comment('1 = rekening untuk withdraw');
            $table->decimal('saldo_awal', 20, 2)->nullable()->default(0.00);
            $table->decimal('saldo_akhir', 20, 2)->nullable()->default(0.00);
            $table->string('koreksi', 50)->nullable()->comment('update, plus, minus');
            $table->decimal('jumlah_koreksi_balance', 13, 2)->nullable()->default(0.00);
            $table->string('deskripsi')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('rekening');
    }
}
