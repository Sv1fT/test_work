<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

class ProductController extends Controller
{

    private Builder $products;

    public function __construct(Product $product)
    {
        $this->products = $product->with('categories');
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(ProductFilter $filter): AnonymousResourceCollection
    {
        $products = $this->products->filter($filter)->get();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return ProductResource
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        $product = $this->products->create($request->validated());

        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Response
     * @throws Throwable
     */
    public function destroy(Product $product): Response
    {
        $product->deleteOrFail();

        return response(null, 204);
    }
}
