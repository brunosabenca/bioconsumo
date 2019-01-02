<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;

class UpdateProductsTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_product_can_be_updated()
	{
		$product = factory('App\Product')->create();

		$this->patchJson($product->path(), [
			'name' => 'Changed name',
			'description'  => 'Changed description',
			'price' => 42
		]);

		tap($product->fresh(), function ($product) {
			$this->assertEquals('Changed name', $product->name);
			$this->assertEquals('Changed description', $product->description);
			$this->assertEquals(42, $product->price);
		});
	}
}
