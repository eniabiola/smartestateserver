<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billing_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estate_id');
            $table->string('name', 50);
            $table->string('description');
            $table->string('invoiceNo', 20);
            $table->decimal('amount', 15, 2);
            $table->string('status', 30);
            $table->boolean('isActive')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('billing_id', 'invoices_billing_id_foreign')->references('id')->on('billings');
            $table->foreign('estate_id', 'invoices_estate_id_foreign')->references('id')->on('estates');
            $table->foreign('user_id', 'invoices_user_id_foreign')->references('id')->on('users');
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
}
