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
        Schema::table('role_module_access', function (Blueprint $table) {
            $table->foreign(['module_access_id'])->references(['id'])->on('module_accesses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_module_access', function (Blueprint $table) {
            $table->dropForeign('role_module_access_module_access_id_foreign');
            $table->dropForeign('role_module_access_role_id_foreign');
        });
    }
};
