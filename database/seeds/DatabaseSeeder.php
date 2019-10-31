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
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        //$this->call(ImageSeeder::class);
        $this->call(GroupOrdersTableSeeder::class);
        $this->call(GroupOrderSellerTableSeeder::class);
    }
}
