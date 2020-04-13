<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         Permission::create(['name' => 'edit item']);
         Permission::create(['name' => 'delete item']);
         Permission::create(['name' => 'add item']);
         Permission::create(['name' => 'view item']);
         Permission::create(['name' => 'view order']);

         $admin = Role::create(['name' => 'admin']);
         $admin->givePermissionTo(['delete item', 'add item', 'view item', 'edit item', 'view order']);
         Permission::create(['name' => 'order item']);
         $client = Role::create(["name" => 'client']);
         $client->givePermissionTo(['order item', 'view order']);
    }
}
