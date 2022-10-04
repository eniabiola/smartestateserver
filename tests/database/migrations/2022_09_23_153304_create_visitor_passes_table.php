<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorPassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_passes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estate_id')->default(1);
            $table->string('generatedCode', 15);
            $table->string('guestName', 100)->nullable();
            $table->string('status');
            $table->text('authorization_comment')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('visitationDate');
            $table->dateTime('generatedDate');
            $table->dateTime('dateExpires');
            $table->integer('duration')->default(2);
            $table->dateTime('checked_in_time')->nullable();
            $table->dateTime('checked_out_time')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->enum('pass_type', ['individual', 'group']);
            $table->integer('additional_guests_number')->nullable();
            
            $table->foreign('estate_id', 'visitor_passes_estate_id_foreign')->references('id')->on('estates');
            $table->foreign('user_id', 'visitor_passes_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_passes');
    }
}
