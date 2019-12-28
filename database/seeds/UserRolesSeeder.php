<?php

use Illuminate\Database\Seeder;
use App\Role;
class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_super_user = new App\Role;
        $role_user = new App\Role;

        $role_super_user->name = "super_admin";
        $role_super_user->save();

        $role_user->name = "admin";
        $role_user->save();
    }
}
