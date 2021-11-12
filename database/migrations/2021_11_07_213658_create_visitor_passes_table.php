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
            $table->unsignedBigInteger('visitor_pass_category_id');
            $table->string('generatedCode', 15);
            $table->string('guestName');
            $table->string('gender');
            $table->string('pass_status');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('visitationDate');
            $table->dateTime('generatedDate');
            $table->date('dateExpires');
            $table->boolean('isRecurrent')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('visitor_pass_category_id')->on('visitor_pass_categories')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors_passes');
    }
}
