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
            'name' => 'Bruno Sabença',
            'email' => 'bruno@example.com',
            'password' => Hash::make('example')
        ])->first();
        $user->assignRole('admin');

        $user = factory(App\Buyer::class, 1)->create([
            'name' => 'Joel Martins',
            'email' => 'joel@example.com',
            'password' => Hash::make('example'),
        ])->first();
        $user->assignRole('buyer');

        $user = factory(App\Seller::class, 1)->create([
            'name' => 'Ivo Barros',
            'email' => 'ivo@example.com',
            'password' => Hash::make('example'),
        ])->first();
        $user->assignRole('seller');

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
