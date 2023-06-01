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
        Schema::table('notification_groups', function (Blueprint $table) {
            $table->foreign(['estate_id'])->references(['id'])->on('estates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_groups', function (Blueprint $table) {
            $table->dropForeign('notification_groups_estate_id_foreign');
        });
    }
};
