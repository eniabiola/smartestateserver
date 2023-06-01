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
        Schema::table('user_notificationgroup', function (Blueprint $table) {
            $table->foreign(['notification_group_id'])->references(['id'])->on('notification_groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::table('user_notificationgroup', function (Blueprint $table) {
            $table->dropForeign('user_notificationgroup_notification_group_id_foreign');
            $table->dropForeign('user_notificationgroup_user_id_foreign');
        });
    }
};
