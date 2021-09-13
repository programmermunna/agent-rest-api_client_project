<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            // $table->string('referal', 50)->comment('kedepan tidak dipakai');
            $table->unsignedBigInteger('rek_member_id')->nullable();
            $table->string('referrer_id')->unique()->nullable()->comment('for referal');
            $table->string('referal')->unique()->nullable();
            $table->enum('type', ['admin', 'user'])->default('user');
            $table->decimal('bonus_referal', 13, 2)->nullable();
            $table->string('username')->unique();
            $table->boolean('is_cash')->default(false);
            $table->boolean('is_new_member')->default(true)->comment('1 = New Member');
            $table->boolean('is_next_deposit')->default(true)->comment('1 = Next Deposit');
            // $table->integer('constant_rekening_id')->nullable()->comment('kedepan tidak dipakai');
            // $table->string('nama_rekening', 50)->nullable()->comment('kedepan tidak dipakai');
            // $table->string('nomor_rekening', 50)->nullable()->comment('kedepan tidak dipakai');
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique();
            $table->integer('rekening_id_tujuan_depo')->nullable();
            $table->float('credit', 13, 2)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable();
            $table->unsignedTinyInteger('active')->default(1);
            $table->boolean('status')->default(true)->comment('0=banned, 1=active, 2=suspend');
            $table->string('info_dari', 50)->nullable();
            $table->string('info_dari_lainnya', 50)->nullable();
            $table->string('timezone')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 20)->nullable();
            $table->boolean('to_be_logged_out')->default(false);
            // $table->string('provider')->nullable()->comment('kedepan tidak dipakai');
            // $table->string('provider_id')->nullable()->comment('kedepan tidak dipakai');
            $table->string('remember_token', 100)->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('members');
    }
}
