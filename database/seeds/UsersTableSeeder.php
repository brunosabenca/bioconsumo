<?php

use Illuminate\Database\Seeder;
use Laravolt\Avatar\Avatar;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatar = new Avatar();

        $user = factory(App\Admin::class, 1)->create([
            'name' => 'Bruno',
            'email' => 'bruno@bruno.com',
            'password' => bcrypt('sabenca')
        ])->first();
        $user->assignRole('admin');
        $avatar->create($user->name)->save(public_path('images/avatars/' . $user->id . '.png'), $quality = 90);

        $user = factory(App\Buyer::class, 1)->create([
            'name' => 'Joel',
            'email' => 'joel@joel.com',
            'password' => bcrypt('martins'),
        ])->first();
        $user->assignRole('buyer');
        $avatar->create($user->name)->save(public_path('images/avatars/' . $user->id . '.png'), $quality = 90);

        $user = factory(App\Seller::class, 1)->create([
            'name' => 'Ivo',
            'email' => 'ivo@ivo.com',
            'password' => bcrypt('barros'),
        ])->first();
        $user->assignRole('seller');
        $avatar->create($user->name)->save(public_path('images/avatars/' . $user->id . '.png'), $quality = 90);

        factory(App\Seller::class, 3)->create() 
            ->each( 
                function ($seller) {
                    factory(App\Product::class, 10)->create()
                            ->each(
                                function($product) use (&$seller) { 
                                    $seller->products()->save($product)->make();
                                    $avatar = new Avatar();
                                    $avatar->create($seller->name)->save(public_path('images/avatars/' . $seller->id . '.png'), $quality = 90);
                                }
                            );
                }
            );
    }
}
