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
        Schema::table('estates', function (Blueprint $table) {
            $table->foreign(['bank_id'])->references(['id'])->on('banks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['country_id'])->references(['id'])->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['state_id'])->references(['id'])->on('states')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->dropForeign('estates_bank_id_foreign');
            $table->dropForeign('estates_city_id_foreign');
            $table->dropForeign('estates_country_id_foreign');
            $table->dropForeign('estates_created_by_foreign');
            $table->dropForeign('estates_state_id_foreign');
        });
    }
};
