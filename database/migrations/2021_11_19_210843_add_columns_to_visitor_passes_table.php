<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToVisitorPassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_passes', function (Blueprint $table) {
            $table->dateTime('checked_in_time')->nullable()->after('duration');
            $table->dateTime('checkout_out_time')->nullable()->after('checked_in_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitor_passes', function (Blueprint $table) {
            //
        });
    }
}
