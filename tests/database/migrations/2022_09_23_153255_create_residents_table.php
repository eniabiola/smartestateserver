<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('meterNo', 40)->nullable();
            $table->unsignedBigInteger('street_id')->nullable();
            $table->string('houseNo', 6);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('street_id', 'residents_street_id_foreign')->references('id')->on('streets');
            $table->foreign('user_id', 'residents_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residents');
    }
}
