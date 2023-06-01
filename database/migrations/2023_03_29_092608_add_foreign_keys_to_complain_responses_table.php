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
        Schema::table('complain_responses', function (Blueprint $table) {
            $table->foreign(['complain_id'])->references(['id'])->on('complains')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['estate_id'])->references(['id'])->on('estates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complain_responses', function (Blueprint $table) {
            $table->dropForeign('complain_responses_complain_id_foreign');
            $table->dropForeign('complain_responses_estate_id_foreign');
            $table->dropForeign('complain_responses_user_id_foreign');
        });
    }
};
