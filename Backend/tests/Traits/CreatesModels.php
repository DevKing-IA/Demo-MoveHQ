<?php

namespace MovehqAppTests\Traits;

use MovehqApp\Models\Product;
use MovehqApp\Models\User;

trait CreatesModels
{
    /**
     * @param array $data
     * @return User
     */
    public function createUser($data = [])
    {
        $user = User::factory()->create($data);

        return $user;
    }

    /**
     * @param array $data
     * @return Product
     */
    public function createProduct($data = [])
    {
        $product = Product::factory()->create($data);

        return $product;
    }
}
