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
            $table->decimal('amount', 15, 2);
            $table->string('bill_frequency', 50);
            $table->string('bill_target', 50);
            $table->string('bill_user_target', 10)->default('all')->comment("options include all, street, random");
            $table->integer('invoice_day')->comment("The day the invoice will be sent.");
            $table->integer('invoice_month')->nullable()->comment("if yearly, the month the invoice will be sent.");
            $table->string('status', 10)->default('active');
            $table->unsignedBigInteger('estate_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('created_by', 'billings_created_by_foreign')->references('id')->on('users');
            $table->foreign('estate_id', 'billings_estate_id_foreign')->references('id')->on('estates');
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
