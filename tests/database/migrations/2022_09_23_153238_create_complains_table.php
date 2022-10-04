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
            $table->string('status')->default('open')->comment("should contain open, active, closed");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('complain_category_id', 'complains_complain_category_id_foreign')->references('id')->on('complain_categories');
            $table->foreign('estate_id', 'complains_estate_id_foreign')->references('id')->on('estates');
            $table->foreign('user_id', 'complains_user_id_foreign')->references('id')->on('users');
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
