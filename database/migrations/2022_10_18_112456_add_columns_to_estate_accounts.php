<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEstateAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estate_accounts', function (Blueprint $table) {
        $table->string('split_type', 20)->default('percentage')
            ->comment('flat,percentage')->after('account_name');
        $table->string('split_value', '5')->after('bank_code');
        $table->string('flutter_id')->after('estate_id')->nullable();
        $table->string('subaccount_id', 40)->after('estate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estate_accounts', function (Blueprint $table) {
            //
        });
    }
}
