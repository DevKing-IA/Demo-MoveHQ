<?php

namespace MovehqApp\Http\Controllers\AdminApi;

use Exception;
use Illuminate\Http\Request;
use MovehqApp\Models\Product;

class ProductController extends ApiBaseController
{
    public function index(Request $request)
    {
        $pageSize = 20;
        $page = $request->get('page', 0);
        $pageOffset = $page * $pageSize;

        if ($request->has('sort')) {
            $sort = $request->sort;
            $sort = explode('-', $sort);
        } else {
            $sort = ['created_at', 'desc'];
        }

        $query = Product::orderBy($sort[0], $sort[1]);

        if ($request->has('search')) {
            $search_param = $request->search;
            $query->where('name', 'like', '%' . $search_param . '%');
        }

        return [
            'count' => $query->count(),
            'products' => $query->limit($pageSize)->offset($pageOffset)->get(),
        ];
    }

    /**
     * Removing the product
     */
    public function remove(Request $request)
    {
        if ($request->has('id')) {
            $productId = $request->get('id');
            Product::where('id', $productId)->delete();

            return [
                'success' => true,
            ];
        } else {
            throw new Exception('Please provide valid product id');
        }
    }

    /**
     * Creating the product random content
     */
    public function createRandom()
    {
        Product::factory()->create();

        return [
            'success' => true,
        ];
    }
}
