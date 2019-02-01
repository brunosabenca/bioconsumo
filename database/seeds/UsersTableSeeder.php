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
        factory(App\Admin::class, 1)->create([
            'name' => 'Bruno',
            'email' => 'bruno@bruno.com',
            'password' => bcrypt('sabenca')
        ])->first()->assignRole('admin');

        factory(App\Buyer::class, 1)->create([
            'name' => 'Joel',
            'email' => 'joel@joel.com',
            'password' => bcrypt('martins'),
        ])->first()->assignRole('buyer');

        factory(App\Seller::class, 1)->create([
            'name' => 'Ivo',
            'email' => 'ivo@ivo.com',
            'password' => bcrypt('barros'),
        ])->each(function ($user) { $user->assignRole('seller');});

        factory(App\Seller::class, 3)->create() 
            ->each( 
                function ($seller) {
                    factory(App\Product::class, 10)->create()
                            ->each(
                                function($product) use (&$seller) { 
                                    $seller->products()->save($product)->make();
                                }
                            );
                }
            );
    }
}
