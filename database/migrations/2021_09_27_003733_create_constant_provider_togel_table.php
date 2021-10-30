<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstantProviderTogelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constant_provider_togel', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('market name');
            $table->string('name_initial', 20)->unique()->comment('initial for name');
            $table->text('website_url')->comment('website url');
            $table->string('period', 11)->nullable();
            $table->string('hari_diundi')->comment('');
            $table->string('libur')->nullable()->comment('hari libur');
            $table->string('tutup', 50)->comment('jam tutup');
            $table->string('jadwal', 50);
            $table->boolean('status')->comment('1 = online');
            $table->boolean('auto_online')->comment('1 = online');
            $table->boolean('auto_submit')->comment('1 = submit');
            $table->unsignedBigInteger('created_by')->comment('column id in users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('column id in users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('column id in users table');
            $table->timestamp('created_at')->comment('date when row was created');
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
        Schema::dropIfExists('constant_provider_togel');
    }
}
