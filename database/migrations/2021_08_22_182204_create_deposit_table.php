<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit', function (Blueprint $table) {
            $table->id();
            $table->integer('members_id')->comment('user id di front panel');
            $table->integer('rekening_id')->comment('Rekening bank tujuan');
            $table->decimal('jumlah', 13, 2)->nullable()->default(0.00);
            $table->integer('rek_member_id');
            $table->boolean('is_claim_next_deposit')->default(false)->comment('1 = Claim Bonus Next Deposit');
            $table->boolean('is_claim_new_member')->default(false)->comment('1 = Claim Bonus New Member');
            $table->boolean('is_next_bonus_depo')->default(false)->comment('1 = get next bonus depo')->nullable();
            $table->boolean('is_status')->default(false)->comment('1 = 1 : sudah bisa to wd');
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
        Schema::dropIfExists('deposit');
    }
}
