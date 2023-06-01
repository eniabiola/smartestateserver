<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_passes', function (Blueprint $table) {
            $table->foreign(['estate_id'])->references(['id'])->on('estates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->dropForeign('visitor_passes_estate_id_foreign');
            $table->dropForeign('visitor_passes_user_id_foreign');
        });
    }
};
