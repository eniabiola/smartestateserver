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
        Schema::create('complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('complain_category_id')->index('complains_complain_category_id_foreign');
            $table->unsignedBigInteger('user_id')->index('complains_user_id_foreign');
            $table->unsignedBigInteger('estate_id')->index('complains_estate_id_foreign');
            $table->string('ticket_no', 10);
            $table->string('subject', 20);
            $table->string('priority', 20);
            $table->string('file', 255)->nullable();
            $table->text('description');
            $table->string('status', 255)->default('open')->comment('should contain open, active, closed');
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
        Schema::dropIfExists('complains');
    }
};
