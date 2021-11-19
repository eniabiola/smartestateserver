<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditVisitorsPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_passes', function (Blueprint $table){
            $table->dropForeign('visitor_passes_visitor_pass_category_id_foreign');
            $table->dropColumn('visitor_pass_category_id');
            $table->dropColumn('gender');
            $table->dropColumn('isRecurrent');
            $table->dateTime('dateExpires')->change();
            $table->integer('duration')->after('dateExpires')->default(2);
            $table->boolean('isActive')->default(true)->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
