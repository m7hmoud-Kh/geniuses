<?php

namespace App\Services\Models;

use App\Http\Resources\ModuleResource;
use App\Models\Media;
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
        $module = Module::create($request->except(['image','attachments']));
        $this->dataImage['title'] = $request->name;
        $this->dataImage['image'] = $request->image;
        $this->dataModel['model'] = $module;
        $this->handleImageNameAndInsertInDb($this->dataImage,$this->dataModel);
        if($request->file('attachments')){
            $this->dataModel['relation'] = 'attachments';
            $this->insertMultipleImage($request->attachments,$this->dataImage['title'],$this->dataModel['model'],
            Module::DIR,$this->dataModel['relation']);
        }
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new ModuleResource($module)
        ],Response::HTTP_CREATED);
    }

    public function showModule(Module $module)
    {
        $module = $module->load(['mediaFirst','category','attachments']);
        return response()->json([
            'data' => new ModuleResource($module)
        ]);
    }

    public function updateModule(Request $request,Module $module)
    {
        $this->dataImage['title'] = $request->name ?? $module->name;
        $this->dataModel['model'] = $module;
        if($request->file('image')){
            $this->dataImage['image'] = $request->image;
            $this->deleteImage(Module::DISK_NAME,$module->mediaFirst);
            $this->handleImageNameAndInsertInDb($this->dataImage, $this->dataModel);
        }
        if($request->file('attachments')){
            $this->dataModel['relation'] = 'attachments';
            $this->insertMultipleImage($request->attachments,$this->dataImage['title'],$this->dataModel['model'],Module::DIR, $this->dataModel['relation']);
        }
        $module->update($request->except(['image','attachments']));
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new ModuleResource($module)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryModule($module)
    {
        $this->deleteImage(Module::DISK_NAME,$module->mediaFirst);
        $this->deleteIMageFromLoaclStorage(Module::DISK_NAME, $module->attachments);
        $module->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

    public function destoryAttachment($attachmentId)
    {
        $media = Media::where('file_type','document')->findOrFail($attachmentId);
        $this->deleteImage(Module::DISK_NAME,$media);
        $media->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
