<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estate_id');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->double('gateway_commission', 20, 2)->comment("This should have been calculated and not the percentage");
            $table->double('total_amount', 20, 2)->comment("Amount resident finally pays");
            $table->enum('transaction_type', ['credit', 'debit']);
            $table->string('transaction_status', 30);
            $table->string('transaction_reference', 100);
            $table->dateTime('date_initiated');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('estate_id', 'transactions_estate_id_foreign')->references('id')->on('estates');
            $table->foreign('user_id', 'transactions_user_id_foreign')->references('id')->on('users');
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
}
