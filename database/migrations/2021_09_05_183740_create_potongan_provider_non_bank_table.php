<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePotonganProviderNonBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('potongan_provider_non_bank', function (Blueprint $table) {
            $table->id();
            $table->integer('rek_member_id');
            $table->integer('constant_rekening_id');
            $table->string('event');
            $table->string('jumlah');
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
        Schema::dropIfExists('potongan_provider_non_bank');
    }
}
