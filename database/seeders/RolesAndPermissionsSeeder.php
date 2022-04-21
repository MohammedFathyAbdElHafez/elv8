<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'employee']);
        $role3 = Role::create(['name' => 'customer']);


        $permission1 = Permission::create(['name' => 'create employees']);
        $permission2 = Permission::create(['name' => 'create customers']);

        $role1->syncPermissions(Permission::all());
        $role2->syncPermissions($permission2);

    }
}
