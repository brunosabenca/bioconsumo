<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
                'name' => 'Potatoes',
                'description' => 'Potatoes are tubers that are a staple food in many parts of the world, particularly Europe and the West.',
                'price' => 10,
                'user_id' => 2,
                'stock' => 100,
                'stock_unit_type' => '50 Kg bag',
            ]);
        DB::table('products')->insert([
                'name' => 'Sweet potatoes',
                'description' => 'The sweet potato is a dicotyledonous plant that belongs to the bindweed or morning glory family, Convolvulaceae. Its large, starchy, sweet-tasting, tuberous roots are a root vegetable. The young leaves and shoots are sometimes eaten as greens.',
                'price' => 3,
                'user_id' => 3,
                'stock' => 100,
                'stock_unit_type' => 'g',
            ]);
        DB::table('products')->insert([
                'name' => 'Mizuna',
                'description' => 'Mizuna, qian jing shui cai, kyona, Japanese mustard greens, or spider mustard, is a cultivated crop plant from the species Brassica rapa var. niposinica a dark green, serrated leafed plant.',
                'price' => 4,
                'user_id' => 2,
                'stock' => 100,
                'stock_unit_type' => 'g',
            ]);
        DB::table('products')->insert([
                'name' => 'Green olives',
                'description' => 'Olives are small fruit. They are very high in antioxidants and healthy fats.',
                'price' => 1,
                'user_id' => 3,
                'stock' => 2,
                'stock_unit_type' => 'Kg',
            ]);
        DB::table('products')->insert([
                'name' => 'Brazil nuts',
                'description' => "The Brazil nut is a South American tree in the family Lecythidaceae, and also the name of the tree's commercially harvested edible seeds.",
                'price' => 5,
                'user_id' => 2,
                'stock' => 100,
                'stock_unit_type' => 'handful',
            ]);
        DB::table('products')->insert([
                'name' => 'Macadamia nuts',
                'description' => "Macadamia is a genus of four species of trees indigenous to Australia, and constituting part of the plant family Proteaceae. They are native to north eastern New South Wales and central and south eastern Queensland.",
                'price' => 7,
                'user_id' => 3,
                'stock' => 10,
                'stock_unit_type' => 'Kg'
            ]);
    }
}