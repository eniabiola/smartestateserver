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
        Schema::create('visitor_passes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estate_id')->default(1)->index('visitor_passes_estate_id_foreign');
            $table->string('generatedCode', 15);
            $table->string('guestName', 100)->nullable();
            $table->string('status', 255);
            $table->text('authorization_comment')->nullable();
            $table->unsignedBigInteger('user_id')->index('visitor_passes_user_id_foreign');
            $table->dateTime('visitationDate');
            $table->dateTime('generatedDate');
            $table->dateTime('dateExpires');
            $table->integer('duration')->default(2);
            $table->dateTime('checked_in_time')->nullable();
            $table->dateTime('checked_out_time')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->enum('pass_type', ['individual', 'group']);
            $table->integer('additional_guests_number')->nullable();
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
};
