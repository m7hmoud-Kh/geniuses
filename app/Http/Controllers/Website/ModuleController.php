<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Models\ModuleModel;
use Illuminate\Http\Request;

class ModuleController extends Controller
{

    public function show(Request $request,ModuleModel $moduleModel)
    {
        return $moduleModel->showActiveModule($request->module_id);
    }
}
