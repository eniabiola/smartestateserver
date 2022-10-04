<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('prev_balance', 15, 2)->default(0.00);
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('current_balance', 15, 2)->default(0.00);
            $table->enum('transaction_type', ['credit', 'debit', 'opening', 'closing'])->default('opening');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('user_id', 'wallets_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
