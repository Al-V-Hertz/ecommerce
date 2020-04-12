<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class SuperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Albert",
            'email' => 'albert@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $super = Role::create(['name'=> "superadmin"]);
        $super->givePermissionTo(['delete item', 'add item', 'view item', 'edit item']);
        $user->assignRole('superadmin');
    }
}
