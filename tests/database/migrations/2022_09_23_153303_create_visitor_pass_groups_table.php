<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorPassGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_pass_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_pass_id');
            $table->string('event');
            $table->integer('expected_number_of_guests');
            $table->integer('number_of_guests_in')->nullable();
            $table->integer('number_of_guests_out')->nullable();
            $table->boolean('isApproved')->default(0);
            $table->dateTime('authorized_date')->nullable();
            $table->unsignedBigInteger('authorized_by')->nullable();
            $table->timestamps();
            
            $table->foreign('authorized_by', 'visitor_pass_groups_authorized_by_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_pass_groups');
    }
}
