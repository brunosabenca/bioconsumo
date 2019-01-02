<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_products()
    {
        $product = factory('App\Product')->create();

        $response = $this->get('/products');
        $response->assertSee($product->title);
    }

    /** @test */
    public function a_user_can_view_a_single_product()
    {
        $product = factory('App\Product')->create();

        $response = $this->get($product->path());
        $response->assertSee($product->name);
    }
}
