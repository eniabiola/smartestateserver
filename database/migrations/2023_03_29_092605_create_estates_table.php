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
        Schema::create('estates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id')->index('estates_city_id_foreign');
            $table->unsignedBigInteger('state_id')->index('estates_state_id_foreign');
            $table->unsignedBigInteger('country_id')->default(156)->index('estates_country_id_foreign');
            $table->unsignedBigInteger('bank_id')->index('estates_bank_id_foreign');
            $table->string('estateCode', 20);
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 17);
            $table->string('address', 255);
            $table->string('contactPerson', 100);
            $table->string('accountNumber', 12);
            $table->string('accountName', 100);
            $table->string('imageName', 100);
            $table->boolean('accountVerified')->default(false);
            $table->string('alternativeContact', 100)->nullable();
            $table->string('alternateEmail', 100)->nullable();
            $table->string('alternatePhone', 17)->nullable();
            $table->string('status', 255)->default('pending')->comment('The options here
            are pending, active, inactive');
            $table->unsignedBigInteger('created_by')->index('estates_created_by_foreign');
            $table->boolean('isActive')->default(true);
            $table->string('mail_slug', 10);
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
        Schema::dropIfExists('estates');
    }
};
