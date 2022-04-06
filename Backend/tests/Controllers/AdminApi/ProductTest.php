<?php

namespace MovehqAppTests\Controllers\AdminApi;

use MovehqAppTests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        $user = $this->createUser();

        $this->actingAs($user);
        $response = $this->postJson('/admin-api/product/create-random', []);

        $this->assertIsBool($response->json('success'));
        $this->assertTrue($response->json('success'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $user = $this->createUser();
        $product = $this->createProduct();
        $this->assertNull($product->deleted_at);

        $this->actingAs($user);
        $response = $this->postJson('/admin-api/product/remove', ['id' => $product->id]);

        $this->assertIsBool($response->json('success'));
        $this->assertTrue($response->json('success'));

        $product->refresh();
        $this->assertNotNull($product->deleted_at);
    }
}
