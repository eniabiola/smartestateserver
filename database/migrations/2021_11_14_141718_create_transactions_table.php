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
            $table->decimal('amount', 10,2);
            $table->enum('transaction_type', ['credit', 'wallet']);
            $table->string('transaction_status', 30);
            $table->string('transaction_reference', 100);
            $table->dateTime('date_initiated');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('estate_id')->references('id')->on('estates');
            $table->foreign('user_id')->references('id')->on('users');
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
