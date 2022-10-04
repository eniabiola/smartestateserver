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
            $table->unsignedBigInteger('country_id')->default(156);
            $table->unsignedBigInteger('bank_id');
            $table->string('estateCode', 20);
            $table->string('name', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('phone', 17);
            $table->string('address');
            $table->string('contactPerson');
            $table->string('accountNumber', 12);
            $table->string('accountName', 100);
            $table->string('imageName', 100);
            $table->boolean('accountVerified')->default(0);
            $table->string('alternativeContact', 100)->nullable();
            $table->string('alternateEmail', 100)->nullable();
            $table->string('alternatePhone', 17)->nullable();
            $table->string('status')->default('pending')->comment("The options here are pending, active, inactive");
            $table->unsignedBigInteger('created_by');
            $table->boolean('isActive')->default(1);
            $table->string('mail_slug', 10);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('bank_id', 'estates_bank_id_foreign')->references('id')->on('banks');
            $table->foreign('city_id', 'estates_city_id_foreign')->references('id')->on('cities');
            $table->foreign('country_id', 'estates_country_id_foreign')->references('id')->on('countries');
            $table->foreign('created_by', 'estates_created_by_foreign')->references('id')->on('users');
            $table->foreign('state_id', 'estates_state_id_foreign')->references('id')->on('states');
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
