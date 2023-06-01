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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('billing_id')->index('invoices_billing_id_foreign');
            $table->unsignedBigInteger('user_id')->index('invoices_user_id_foreign');
            $table->unsignedBigInteger('estate_id')->index('invoices_estate_id_foreign');
            $table->string('name', 50);
            $table->string('description', 255);
            $table->string('invoiceNo', 20);
            $table->decimal('amount', 15);
            $table->string('status', 30);
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('invoices');
    }
};
