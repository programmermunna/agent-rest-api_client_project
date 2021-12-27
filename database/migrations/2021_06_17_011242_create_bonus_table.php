<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique()->nullable();
            $table->string('name');
            $table->string('event');
            $table->decimal('amount', 13, 2)->default(0.00);
            $table->boolean('status')->default(1);
            $table->enum('event_type', ['bonus', 'promo'])->default('bonus');
            $table->unsignedBigInteger('upload_bonus_id');
            $table->foreign('upload_bonus_id')->references('id')->on('upload_bonus');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('bonus');
    }
}
