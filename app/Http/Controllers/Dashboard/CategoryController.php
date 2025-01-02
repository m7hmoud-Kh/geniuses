<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public $categoryModel;
    public function __construct(CategoryModel $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->categoryModel->getAllCategories();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        return $this->categoryModel->storeCategory($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->categoryModel->showCategory($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return $this->categoryModel->updateCategory($request, $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return $this->categoryModel->destoryCategory($category);
    }

    public function getAllCategoriesInSelections()
    {
        return $this->categoryModel->getAllCategoriesInSelections();
    }
}
