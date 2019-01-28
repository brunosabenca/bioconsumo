<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GroupOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_orders')->insert([
                'open_date' => Carbon::now(),
                'close_date' => Carbon::now()->addDays(3),
                'open' => 1,
            ]);
    }
}
