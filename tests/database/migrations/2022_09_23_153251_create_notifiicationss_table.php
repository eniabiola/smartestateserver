<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifiicationssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifiicationss', function (Blueprint $table) {
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
            $table->string('recipient_type', 20)->nullable()->comment("expected values include all,single,group,street");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('created_by', 'notifiications_created_by_foreign')->references('id')->on('users');
            $table->foreign('estate_id', 'notifiications_estate_id_foreign')->references('id')->on('estates');
            $table->foreign('group_id', 'notifiications_group_id_foreign')->references('id')->on('notification_groups');
            $table->foreign('receiver_id', 'notifiications_receiver_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifiicationss');
    }
}
