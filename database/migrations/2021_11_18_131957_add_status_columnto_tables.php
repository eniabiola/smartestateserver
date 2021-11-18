<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumntoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('isActive')->default(true)->after('remember_token');
        });
        Schema::table('estates', function (Blueprint $table) {
            $table->boolean('isActive')->default(true)->after('created_by');
        });
        Schema::table('streets', function (Blueprint $table) {
            $table->boolean('isActive')->default(true)->after('estate_id');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('isActive')->default(true)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
