<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description');
            $table->decimal('amount', 15,2);
            $table->string('bill_frequency', 50);
            $table->string('bill_target', 50);
            $table->integer('invoice_day')->comment("The day the invoice will be sent.");
            $table->integer('invoice_month')->nullable()->comment("if yearly, the month the invoice will be sent.");
            $table->integer('due_day')->comment("The day the billing is due.");
            $table->integer('due_month') ->nullable()->comment("if yearly, the month the billing is due.");
            $table->string('status', 10)->default('active');
            $table->unsignedBigInteger('estate_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('estate_id')->references('id')->on('estates');
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
        Schema::dropIfExists('billings');
    }
}
