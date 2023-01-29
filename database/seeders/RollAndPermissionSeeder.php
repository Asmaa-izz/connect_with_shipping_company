<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RollAndPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        Permission::firstOrCreate(['name' => 'setting']);
        Permission::firstOrCreate(['name' => 'roles']);
        Permission::firstOrCreate(['name' => 'access_record']);

        Permission::firstOrCreate(['name' => 'access_employee']);
        Permission::firstOrCreate(['name' => 'create_employee']);
        Permission::firstOrCreate(['name' => 'update_employee']);
        Permission::firstOrCreate(['name' => 'delete_employee']);


        $adminPermissions = Permission::all()->pluck('name')->toArray();
        $adminRole->syncPermissions($adminPermissions);


        $employeeRole->syncPermissions([]);


    }
}
