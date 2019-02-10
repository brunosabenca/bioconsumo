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
        $user = factory(App\Admin::class, 1)->create([
            'name' => 'Bruno',
            'email' => 'bruno@bruno.com',
            'password' => bcrypt('sabenca')
        ])->first();
        $user->assignRole('admin');

        $user = factory(App\Buyer::class, 1)->create([
            'name' => 'Joel',
            'email' => 'joel@joel.com',
            'password' => bcrypt('martins'),
        ])->first();
        $user->assignRole('buyer');

        $user = factory(App\Seller::class, 1)->create([
            'name' => 'Ivo',
            'email' => 'ivo@ivo.com',
            'password' => bcrypt('barros'),
        ])->first();
        $user->assignRole('seller');

        $user = factory(App\Seller::class, 1)->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('example'),
        ])->first();
        $user->assignRole('buyer');

        $user = factory(App\Seller::class, 1)->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('example'),
        ])->first();
        $user->assignRole('admin');

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