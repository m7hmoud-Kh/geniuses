<?php

namespace App\Services\Models;

use App\Http\Resources\ModuleResource;
use App\Models\Module;
use App\Services\Utils\Imageable;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModuleModel extends Model
{

    use Paginatable, Imageable;

    public $dataImage = [
        'title' => '',
        'image' => '',
        'dir' => Module::DIR
    ];
    public $dataModel = [
        'model' => '',
        'relation' => 'mediaFirst'
    ];

    public function getAllModules()
    {
        $modules = Module::with('mediaFirst','category')->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => ModuleResource::collection($modules),
            'meta' => $this->getPaginatable($modules)
        ]);
    }

    public function storeModule(Request $request)
    {
        $module = Module::create($request->except(['image']));
        $this->dataImage['title'] = $request->name;
        $this->dataImage['image'] = $request->image;
        $this->dataModel['model'] = $module;
        $this->handleImageNameAndInsertInDb($this->dataImage,$this->dataModel);
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new ModuleResource($module)
        ],Response::HTTP_CREATED);
    }

    public function showModule(Module $module)
    {
        $module = $module->load(['mediaFirst','category']);
        return response()->json([
            'data' => new ModuleResource($module)
        ]);
    }

    public function updateModule(Request $request,Module $module)
    {
        if($request->file('image')){
            $this->dataImage['title'] = $request->name ?? $module->name;
            $this->dataImage['image'] = $request->image;
            $this->dataModel['model'] = $module;
            $this->deleteImage(Module::DISK_NAME,$module->mediaFirst);
            $this->handleImageNameAndInsertInDb($this->dataImage, $this->dataModel);
        }
        $module->update($request->except(['image']));
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new ModuleResource($module)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryModule($module)
    {
        $this->deleteImage(Module::DISK_NAME,$module->mediaFirst);
        $module->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
