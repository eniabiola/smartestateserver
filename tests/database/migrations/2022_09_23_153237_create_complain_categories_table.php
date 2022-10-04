<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique('complain_categories_name_unique');
            $table->string('status', 20);
            $table->unsignedBigInteger('estate_id');
            $table->100`('email');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('estate_id', 'complain_categories_estate_id_foreign')->references('id')->on('estates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complain_categories');
    }
}
