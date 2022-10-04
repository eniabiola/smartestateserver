<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorPassCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_pass_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('visitor_pass_categories_name_unique');
            $table->string('description');
            $table->string('prefix', 10)->nullable();
            $table->integer('numberAllowed');
            $table->tinyInteger('isActive');
            $table->string('email', 50);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_pass_categories');
    }
}
