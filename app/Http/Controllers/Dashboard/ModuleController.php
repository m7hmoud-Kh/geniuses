<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Module\StoreModuleRequest;
use App\Http\Requests\Dashboard\Module\UpdateModuleRequest;
use App\Models\Media;
use App\Models\Module;
use App\Services\Models\ModuleModel;
use Illuminate\Http\Request;

class ModuleController extends Controller
{


    public $moduelModel;
    public function __construct(ModuleModel $moduelModel)
    {
        $this->moduelModel = $moduelModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->moduelModel->getAllModules($request->categoryId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuleRequest $request)
    {

        return $this->moduelModel->storeModule($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        return $this->moduelModel->showModule($module);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuleRequest $request, Module $module)
    {
        return $this->moduelModel->updateModule($request, $module);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        return $this->moduelModel->destoryModule($module);
    }

    public function destroyAttachmentById($attachmentId)
    {
        return $this->moduelModel->destroyAttachment($attachmentId);
    }
}
