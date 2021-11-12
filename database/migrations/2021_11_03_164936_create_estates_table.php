<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('bank_id');
            $table->string('estateCode', 20);
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 17);
            $table->string('address');
            $table->string('accountNumber', 12);
            $table->string('accountName', 100);
            $table->string('imageName', 100);
            $table->boolean('accountVerified')->default(false);
            $table->string('alternateEmail', 100);
            $table->string('alternatePhone', 17);
            $table->string('status')->default('pending')->comment('The options here
            are pending, active, inactive');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estates');
    }
}
