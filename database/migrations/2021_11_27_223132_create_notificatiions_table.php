<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificatiionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifiications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('estate_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('street_id')->nullable();
            $table->string('name', 100);
            $table->string('title', 200);
            $table->longText('message');
            $table->string('file')->nullable();
            $table->string('recipient_type', 20)->nullable()
                  ->comment('expected values include all,single,group,street');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('receiver_id')->on('users')->references('id');
            $table->foreign('group_id')->on('notification_groups')->references('id');
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('estate_id')->on('estates')->references('id');
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
}
