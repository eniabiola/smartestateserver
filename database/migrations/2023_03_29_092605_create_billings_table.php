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
        Schema::create('billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('description', 255);
            $table->decimal('amount', 15);
            $table->string('bill_frequency', 50);
            $table->string('bill_target', 50);
            $table->string('bill_user_target', 10)->nullable()->default('all')->comment('options include all, street, random');
            $table->integer('invoice_day')->comment('The day the invoice will be sent.');
            $table->integer('invoice_month')->nullable()->comment('if yearly, the month the invoice will be sent.');
            $table->string('status', 10)->default('active');
            $table->unsignedBigInteger('estate_id')->index('billings_estate_id_foreign');
            $table->unsignedBigInteger('created_by')->index('billings_created_by_foreign');
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
        Schema::dropIfExists('billings');
    }
};
