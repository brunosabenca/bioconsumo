<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_has_a_path()
    {
        $user = factory(\App\Admin::class)->create();
        $product = factory('App\Product')->create();

        $this->actingAs($user)->assertEquals(
            "/products/{$product->id}",
            $product->path()
        );
    }
}
