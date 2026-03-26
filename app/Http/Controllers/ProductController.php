<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $branchConnection = $request->query('branch');
        $products = Product::onBranch($branchConnection)->get();

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();
        $branchConnection = $request->query('branch');

        try {

            $product = Product::onBranch($branchConnection)->create($data);

            return backWithSuccess(
                data: new ProductResource($product)
            );

        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    public function update(ProductUpdateRequest $request)
    {
        $data = $request->validated();
        $branchConnection = $request->query('branch', 'mysql');
        $product = Product::onBranch($branchConnection)->findOrFail($request->id);

        try {
            $product->update($data);

            return backWithSuccess(
                data: new ProductResource($product)
            );

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy($id)
    {
        $branchConnection = request()->query('branch', 'mysql');
        $product = Product::onBranch($branchConnection)->findOrFail($id);

        try {
            $product->delete();

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
