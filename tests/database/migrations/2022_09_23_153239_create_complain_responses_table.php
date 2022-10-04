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
            $table->boolean('isOwner')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('complain_id', 'complain_responses_complain_id_foreign')->references('id')->on('complains');
            $table->foreign('estate_id', 'complain_responses_estate_id_foreign')->references('id')->on('estates');
            $table->foreign('user_id', 'complain_responses_user_id_foreign')->references('id')->on('users');
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
