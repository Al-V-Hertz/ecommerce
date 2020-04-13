<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(SuperSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        factory(App\Item::class, 50)->create();
        

    }
}
