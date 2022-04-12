<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Throwable;

class CategoryController extends Controller
{
    private Builder $categories;

    public function __construct(Category $category)
    {
        $this->categories = $category->with('products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = $this->categories->create($request->validated());

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     * @throws Throwable
     */
    public function destroy(Category $category): Response
    {
        $category->deleteOrFail();

        return response(null, 204);
    }
}
