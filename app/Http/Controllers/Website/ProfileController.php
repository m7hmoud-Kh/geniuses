<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Models\CategoryModel;
use App\Services\Models\ModuleModel;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showActiveModulesSubscripted(ModuleModel $moduleModel)
    {
        return $moduleModel->showActiveModulesSubscripted();
    }

    public function showActiveCategoriesSubscripted(CategoryModel $categoryModel)
    {
        return $categoryModel->showActiveCategoriesSubscripted();
    }
}
