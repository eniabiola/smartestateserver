<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('cities')->count() == 0)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $sql2 = file_get_contents(database_path() . '/seeders/states.sql');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::statement($sql2);
        }
    }
}
