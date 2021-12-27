<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 20)->comment('user ip address');
            $table->string('description')->nullable()->comment('ip address description');
            $table->boolean('whitelisted')->default(true)->comment("1 = ip user can access website");
            $table->integer('created_by')->nullable()->comment('id of the user who added the row');
            $table->integer('updated_by')->nullable()->comment('id of the user who updated the row');
            $table->integer('deleted_by')->nullable()->comment('id of the user who deleted the row');
            $table->timestamp('created_at')->nullable()->comment('date when row was created');
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
        Schema::dropIfExists('admin_ips');
    }
}
