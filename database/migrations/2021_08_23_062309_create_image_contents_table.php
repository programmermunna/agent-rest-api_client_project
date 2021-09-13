<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('slide_and_popup_images');
        Schema::create('image_contents', function (Blueprint $table) {
            $table->id();
            // constant_promosi_value relation
            // $table->unsignedBigInteger('constant_promosi_value_id')->nullable();
            $table->string('title')->nullable();
            $table->enum('type', ['popup', 'mobile', 'slide', 'promotion', 'turnover','cashback','bonus','bonus_new_member','bonus_next_deposit']);
            $table->string('path');
            $table->string('alt')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('enabled')->default(false);
            $table->longText('content')->nullable();
            $table->integer('value_bonus')->nullable();
            $table->integer('max_bonus_given')->nullable();
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
        Schema::dropIfExists('image_contents');
    }
}
