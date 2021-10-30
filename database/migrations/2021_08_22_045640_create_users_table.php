<?php

use App\Domains\Auth\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [User::TYPE_ADMIN, User::TYPE_USER])->default(User::TYPE_USER)->comment('to differentiate user roles');
            $table->string('username', 50)->unique()->comment('username to login');
            $table->string('name')->comment('user real name');
            $table->string('email', 191)->unique()->comment('user email address');
            $table->timestamp('email_verified_at')->nullable($value = true)->comment('email date after verification');
            $table->string('password')->comment('user password');
            $table->timestamp('password_changed_at')->nullable($value = true)->comment('password change date');
            // tinyint(3)
            $table->unsignedTinyInteger('active')->default(1)->comment('user status is active or inactive, 1 = active 0 = inactive');
            $table->string('timezone')->nullable($value = true)->comment('user time zone');
            $table->timestamp('last_login_at')->nullable($value = true)->comment('last date user logged in');
            $table->string('last_login_ip')->nullable($value = true)->comment('last user ip address');
            $table->boolean('to_be_logged_out')->default(false)->comment('user logout status, 1 = logout 0 = login');
            $table->string('provider')->nullable($value = true)->comment('for integration purposes with authentication service providers');
            $table->string('provider_id')->nullable($value = true)->comment('for integration purposes with authentication service providers');
            $table->rememberToken()->comment('save the result of generating token remember me');
            $table->timestamp('created_at')->nullable($value = true)->comment('date when row was created');
            $table->timestamp('updated_at')->nullable($value = true)->comment('date when row was updated');
            $table->timestamp('deleted_at')->nullable($value = true)->comment('date when row was deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
