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
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('wallets_user_id_foreign');
            $table->decimal('prev_balance', 15)->default(0);
            $table->decimal('amount', 15)->nullable();
            $table->decimal('current_balance', 15)->default(0);
            $table->enum('transaction_type', ['credit', 'debit', 'opening', 'closing'])->default('opening');
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
        Schema::dropIfExists('wallets');
    }
};
