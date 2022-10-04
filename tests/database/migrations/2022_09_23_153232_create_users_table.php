<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estate_id')->nullable();
            $table->string('surname', 100);
            $table->string('othernames', 100);
            $table->string('phone', 20);
            $table->string('imageName', 100)->default('default.jpg');
            $table->string('email')->unique('users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('isActive')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('estate_id', 'users_estate_id_foreign')->references('id')->on('estates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
