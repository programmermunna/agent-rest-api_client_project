<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw', function (Blueprint $table) {
            $table->id();
            $table->integer('members_id')->nullable()->default(0.00);
            $table->integer('rekening_id')->nullable()->default(0.00)->comment('Rekening bank asal transfer');
            $table->decimal('jumlah', 13, 2)->nullable()->default(0.00);
            $table->integer('rek_member_id');
            $table->boolean('approval_status')->default(false);
            $table->boolean('is_sound_notified')->default(false)->comment('jika 1 = sound notif sudah berbunyi');
            $table->string('note', 50)->nullable();
            $table->dateTime('approval_status_at')->nullable();
            $table->integer('approval_status_by')->nullable();
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
        Schema::dropIfExists('withdraw');
    }
}
