<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_bets', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique()->nullable();
            $table->string('event', 191);
            $table->decimal('amount', 13, 2)->default(0.00);
            $table->enum('type', ['Rp', '%'])->default('Rp');
            $table->integer('maximum')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('free_bets');
    }
}
