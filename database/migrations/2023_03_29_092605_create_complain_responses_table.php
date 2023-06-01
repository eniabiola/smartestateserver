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
        Schema::create('complain_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('complain_id')->index('complain_responses_complain_id_foreign');
            $table->unsignedBigInteger('user_id')->index('complain_responses_user_id_foreign');
            $table->unsignedBigInteger('estate_id')->index('complain_responses_estate_id_foreign');
            $table->text('response');
            $table->string('file', 255)->nullable();
            $table->string('user_role', 30);
            $table->boolean('isOwner')->default(false);
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
        Schema::dropIfExists('complain_responses');
    }
};
