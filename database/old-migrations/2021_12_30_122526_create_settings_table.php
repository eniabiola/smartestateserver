<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('front_end_url', 150);
            $table->string('security_unit')->nullable();
            $table->string('fire_and_emergency')->nullable();
            $table->string('police_post')->nullable();
            $table->string('hospital')->nullable();
            $table->string('CRI')->nullable();
            $table->string('clinic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
