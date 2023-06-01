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
        Schema::table('billing_streets', function (Blueprint $table) {
            $table->foreign(['billing_id'])->references(['id'])->on('billings')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['street_id'])->references(['id'])->on('streets')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_streets', function (Blueprint $table) {
            $table->dropForeign('billing_streets_billing_id_foreign');
            $table->dropForeign('billing_streets_street_id_foreign');
        });
    }
};
