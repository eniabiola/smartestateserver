<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['front_end_url', 'security_unit', 'fire_and_emergency', 'support_unit','hospital','police_post','CRI','clinic']);
            $table->string('name', 100)->after('id');
            $table->string('value', 100)->after('name');
            $table->string('type', 20)->after('value')->default('string');
            $table->unsignedBigInteger('estate_id')->after('type');

            $table->foreign('estate_id')->references('id')->on('estates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
