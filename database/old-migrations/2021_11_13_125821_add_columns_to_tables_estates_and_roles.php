<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTablesEstatesAndRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_passes', function (Blueprint $table) {
            $table->unsignedBigInteger('estate_id')->after('visitor_pass_category_id')->default(1);

            $table->foreign('estate_id')->references('id')->on('estates');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->string('slug', 20)->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables_estates_and_roles', function (Blueprint $table) {
            //
        });
    }
}
