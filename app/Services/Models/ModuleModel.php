<?php

namespace App\Services\Models;

use App\Http\Resources\ModuleResource;
use App\Models\Media;
use App\Models\Module;
use App\Models\Subscription;
use App\Services\Utils\Imageable;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        'relation' => ''
    ];

    public function getAllModules($categoryId)
    {
        $modules = Module::with('category')->where('category_id',$categoryId)->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => ModuleResource::collection($modules),
            'meta' => $this->getPaginatable($modules)
        ]);
    }

    public function storeModule(Request $request)
    {
        $module = Module::create($request->except(['image','attachments']));
        $this->dataModel['model'] = $module;
        if($request->file('attachments')){
            $this->dataModel['relation'] = 'attachments';
            $this->insertMultipleImage($request->attachments,$this->dataModel['model'],
            Module::DIR,$this->dataModel['relation']);
        }
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new ModuleResource($module)
        ],Response::HTTP_CREATED);
    }

    public function showModule(Module $module)
    {
        $module = $module->load(['category','attachments']);
        return response()->json([
            'data' => new ModuleResource($module)
        ]);
    }

    public function showActiveModule($moduleId)
    {
        $module = Module::with(['category','attachments','exams','lessons'])->Status()->findOrFail($moduleId);
        return response()->json([
            'data' => new ModuleResource($module)
        ]);
    }
    public function showActiveModulesSubscripted()
    {
        $subscriptonsModules = Subscription::where('user_id',Auth::user()->id)
        ->pluck('module_id');
        $modules = Module::with(['exams','lessons'])->Status()->whereIn('id',$subscriptonsModules)->get();
        return response()->json([
            'data' => ModuleResource::collection($modules)
        ]);
    }

    public function updateModule(Request $request,Module $module)
    {
        $this->dataModel['model'] = $module;
        if($request->file('attachments')){
            $this->dataModel['relation'] = 'attachments';
            $this->insertMultipleImage($request->attachments,$this->dataModel['model'],Module::DIR, $this->dataModel['relation']);
        }
        $module->update($request->except(['attachments']));
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new ModuleResource($module)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryModule($module)
    {
        $this->deleteIMageFromLoaclStorage(Module::DISK_NAME, $module->attachments);
        $module->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

    public function destroyAttachment($attachmentId)
    {
        $media = Media::where('file_type','document')->findOrFail($attachmentId);
        $module = Module::whereId($media->meddiable_id)->first();
        $this->dataModel['model'] = $module;
        $this->dataModel['relation'] = 'attachments';
        $this->deleteImage(Module::DISK_NAME,$media,$this->dataModel);
        // $media->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
