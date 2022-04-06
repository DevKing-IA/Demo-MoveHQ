<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MovehqApp\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('production')) {
            echo "ProductSeeder should not be run on prod server\n";
            return;
        }

        DB::table('products')->truncate();

        $data = [
            [
                'name' => 'Test product 1',
                'description' => 'Test product description1',
                'created_at' => '2021-04-05 16:42:20',
                'updated_at' => '2022-04-05 16:42:20',
                'deleted_at' => NULL,
            ],
            [
                'name' => 'Test product 2',
                'description' => 'Test product description2',
                'created_at' => '2021-04-05 16:42:20',
                'updated_at' => '2022-04-05 16:42:20',
                'deleted_at' => NULL,
            ],
            [
                'name' => 'Test product 3',
                'description' => 'Test product description3',
                'created_at' => '2021-04-05 16:42:20',
                'updated_at' => '2022-04-05 16:42:20',
                'deleted_at' => NULL,
            ],
        ];

        Product::insert($data);
    }
}
