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
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign(['created_by'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['estate_id'])->references(['id'])->on('estates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['group_id'])->references(['id'])->on('notification_groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['receiver_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_created_by_foreign');
            $table->dropForeign('notifications_estate_id_foreign');
            $table->dropForeign('notifications_group_id_foreign');
            $table->dropForeign('notifications_receiver_id_foreign');
        });
    }
};
