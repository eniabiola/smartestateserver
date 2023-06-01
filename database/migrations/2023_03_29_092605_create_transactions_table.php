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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('transactions_user_id_foreign');
            $table->unsignedBigInteger('estate_id')->index('transactions_estate_id_foreign');
            $table->string('description', 255);
            $table->decimal('amount', 10);
            $table->double('gateway_commission', 20, 2)->comment('This should have been calculated and not the percentage');
            $table->double('total_amount', 20, 2)->comment('Amount resident finally pays');
            $table->enum('transaction_type', ['credit', 'debit']);
            $table->string('transaction_status', 30);
            $table->string('transaction_reference', 100);
            $table->dateTime('date_initiated');
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
        Schema::dropIfExists('transactions');
    }
};
