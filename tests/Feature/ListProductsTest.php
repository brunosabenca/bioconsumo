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
        $user = factory(\App\Admin::class)->create();
        $product = factory('App\Product')->create();

        $response = $this->actingAs($user)->get($product->path());
        $response->assertSee($product->name);
    }
}
