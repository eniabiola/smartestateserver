<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complain_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estate_id');
            $table->text('response');
            $table->string('file')->nullable();
            $table->string('user_role', 30);
            $table->boolean('isOwner')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('complain_id')->references('id')->on('complains');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('estate_id')->references('id')->on('estates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complain_responses');
    }
}
