<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
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

    public function getAllActiveCategories()
    {
        return $this->categoryModel->getAllActiveCategories();
    }

    public function showCategoryById($categoryId)
    {
        return $this->categoryModel->showActiveCategory($categoryId);
    }
}
