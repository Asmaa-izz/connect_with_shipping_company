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

        // employee
        Permission::firstOrCreate(['name' => 'access_employee']);
        Permission::firstOrCreate(['name' => 'create_employee']);
        Permission::firstOrCreate(['name' => 'update_employee']);
        Permission::firstOrCreate(['name' => 'delete_employee']);

        // shipping
        Permission::firstOrCreate(['name' => 'shipping']);

        // city
        Permission::firstOrCreate(['name' => 'access_city']);
        Permission::firstOrCreate(['name' => 'create_city']);
        Permission::firstOrCreate(['name' => 'update_city']);
        Permission::firstOrCreate(['name' => 'delete_city']);

        // area
        Permission::firstOrCreate(['name' => 'access_area']);
        Permission::firstOrCreate(['name' => 'create_area']);
        Permission::firstOrCreate(['name' => 'update_area']);
        Permission::firstOrCreate(['name' => 'delete_area']);

        // city
        Permission::firstOrCreate(['name' => 'access_neighborhood']);
        Permission::firstOrCreate(['name' => 'create_neighborhood']);
        Permission::firstOrCreate(['name' => 'update_neighborhood']);
        Permission::firstOrCreate(['name' => 'delete_neighborhood']);

        // order
        Permission::firstOrCreate(['name' => 'access_order']);
        Permission::firstOrCreate(['name' => 'create_order']);
        Permission::firstOrCreate(['name' => 'update_order']);
        Permission::firstOrCreate(['name' => 'delete_order']);

        // company
        Permission::firstOrCreate(['name' => 'access_company']);
        Permission::firstOrCreate(['name' => 'create_company']);
        Permission::firstOrCreate(['name' => 'update_company']);
        Permission::firstOrCreate(['name' => 'delete_company']);





        $adminPermissions = Permission::all()->pluck('name')->toArray();
        $adminRole->syncPermissions($adminPermissions);


        $employeeRole->syncPermissions([
            'access_order', 'create_order', 'update_order', 'delete_order'
        ]);


    }
}
