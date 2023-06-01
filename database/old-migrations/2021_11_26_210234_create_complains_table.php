<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complain_category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estate_id');
            $table->string('ticket_no', 10);
            $table->string('subject', 20);
            $table->string('priority', 20);
            $table->string('file')->nullable();
            $table->text('description');
            $table->string('status')->default('open')->comment('should contain open, active, closed');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('complain_category_id')->on('complain_categories')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('complains');
    }
}
