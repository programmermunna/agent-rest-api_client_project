<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('memo_id')->nullable(); //for continues/sub memo replies
            $table->boolean('is_read')->default(false);
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_reply')->default(false);
            $table->boolean('is_bonus')->default(false)->comment('1 = get bonus');
            $table->string('subject')->nullable();
            $table->text('content');
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
        Schema::dropIfExists('memo');
    }
}
