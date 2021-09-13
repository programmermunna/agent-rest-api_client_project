<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstantRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constant_rekening', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->boolean('is_bank')->default(false)->comment('1 = bank, 0 = NonBank');
            $table->boolean('status')->default(true)->comment('1 = online, 2 = offline, 3 = gangguan');
            $table->string('logo', 191)->nullable();
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
        Schema::dropIfExists('constant_rekening');
    }
}
