<?php

use Illuminate\Database\Seeder;

class GroupOrderSellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_order_seller')->insert([
                'group_order_id' => 1,
                'user_id' => 2,
        ]);
        DB::table('group_order_seller')->insert([
                'group_order_id' => 1,
                'user_id' => 3,
        ]);
    }
}
