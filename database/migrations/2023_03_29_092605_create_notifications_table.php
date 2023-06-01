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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by')->nullable()->index('notifications_created_by_foreign');
            $table->unsignedBigInteger('estate_id')->nullable()->index('notifications_estate_id_foreign');
            $table->unsignedBigInteger('receiver_id')->nullable()->index('notifications_receiver_id_foreign');
            $table->unsignedBigInteger('group_id')->nullable()->index('notifications_group_id_foreign');
            $table->unsignedBigInteger('street_id')->nullable();
            $table->string('name', 100);
            $table->string('title', 200);
            $table->longText('message');
            $table->string('file', 255)->nullable();
            $table->string('recipient_type', 20)->nullable()->comment('expected values include all,single,group,street');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
