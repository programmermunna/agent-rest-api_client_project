<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTogelCategoryGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('togel_category_game', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->unsignedBigInteger('created_by')->comment('column id in users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('column id in users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('column id in users table');
            $table->timestamp('created_at')->comment('date when row was created');
            $table->timestamp('updated_at')->nullable()->comment('date when row was updated');
            $table->timestamp('deleted_at')->nullable()->comment('date when row was deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('togel_category_game');
    }
}
