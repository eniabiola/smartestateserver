<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->firstOrCreate(['name' => 'superadministrator', 'guard_name' => 'web']);
        Role::query()->firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        Role::query()->firstOrCreate(['name' => 'user', 'guard_name' => 'web']);


        foreach(\Spatie\Permission\Models\Role::all() as $role) {
            $users = \App\Models\User::factory(5)->create();
            foreach($users as $user){
                $user->assignRole($role);
            }
        }
    }
}
