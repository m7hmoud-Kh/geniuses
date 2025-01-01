<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Models\AssignmentModel;
use App\Services\Models\CategoryModel;
use App\Services\Models\ExamModel;
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

    public function getAllExamResult(ExamModel $examModel)
    {
        return $examModel->getAllExamResult();
    }

    public function getAllAssignments(AssignmentModel $assignmentModel)
    {
        return $assignmentModel->getMyAssignments();
    }
}
