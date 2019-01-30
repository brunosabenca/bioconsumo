<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Bruno',
            'email' => 'bruno@bruno.com',
            'password' => bcrypt('sabenca'),
        ]);
        DB::table('users')->insert([
            'name' => 'Joel',
            'email' => 'joel@joel.com',
            'password' => bcrypt('martins'),
            'type' => 'seller'
        ]);
        DB::table('users')->insert([
            'name' => 'Ivo',
            'email' => 'ivo@ivo.com',
            'password' => bcrypt('barros'),
            'type' => 'seller'
        ]);
    }
}
