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

            $table->string('referal', 50) ->nullable();
            $table->unsignedBigInteger('rek_member_id')->nullable();
            $table->enum('type', ['admin', 'user'])->default('user');
            $table->boolean('is_cash')->default(0);
            $table->decimal('bonus_referal', 13, 2)->nullable();
            $table->decimal('credit', 13, 2)->nullable()->default(0.00);
            $table->unsignedBigInteger('referrer_id')->nullable()->comment('for referal');
            $table->string('username', 50)->unique()->nullable();
            $table->string('device', 191);
            $table->boolean('is_next_deposit')->default(1)->comment('1 = Next Deposit');
            $table->boolean('is_new_member')->default(1)->comment('1 = New Member');
            $table->integer('constant_rekening_id')->nullable()->comment('kedepan tidak dipakai');
            $table->string('nama_rekening', 50)->nullable()->comment('kedepan tidak dipakai');
            $table->string('nomor_rekening', 50)->nullable()->comment('kedepan tidak dipakai');
            $table->string('phone', 50)->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('rekening_id_tujuan_depo')->nullable();
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password')->default(null);
            $table->timestamp('password_changed_at')->nullable()->default(null);
            $table->unsignedTinyInteger('active')->default(1);
            $table->boolean('status')->default(1)->comment('0=banned, 1=active, 2=suspend');
            $table->string('info_dari', 50)->nullable();
            $table->string('info_dari_lainnya', 50)->nullable();
            $table->string('timezone')->nullable();
            $table->timestamp('last_login_at')->nullable()->default(null);
            $table->string('last_login_ip')->nullable();
            $table->boolean('to_be_logged_out')->default(0);
            $table->string('provider')->nullable()->comment('kedepan tidak dipakai')->default(null);
            $table->string('provider_id')->nullable()->comment('kedepan tidak dipakai')->default(null);
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->integer('created_by')->nullable()->comment('id of the user who added the row');
            $table->integer('updated_by')->nullable()->comment('id of the user who updated the row');
            $table->integer('deleted_by')->nullable()->comment('id of the user who deleted the row');
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
