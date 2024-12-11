<?php

namespace App\Services\Models;

use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Services\Utils\Imageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AssignmentModel extends Model
{

    use Imageable;

    public $dataImage = [
        'title' => '',
        'image' => '',
        'dir' => Assignment::DIR
    ];
    public $dataModel = [
        'model' => '',
        'relation' => 'mediaFirst'
    ];

    public function index(Request $request)
    {
        $assginments = Assignment::where('module_id', $request->module_id)->where('user_id', Auth::user()->id)->get();
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => AssignmentResource::collection($assginments)
        ],Response::HTTP_CREATED);

    }

    public function showAllAssginmentInModule(Request $request)
    {
        $assginments = Assignment::with('user')
        ->where('module_id', $request->module_id)
        ->get();

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => AssignmentResource::collection($assginments)
        ],Response::HTTP_CREATED);
    }


    public function store(Request $request)
    {
        $assginment = Assignment::create($request->mergeIfMissing([
            'user_id' => Auth::user()->id
        ])->except(['attachment']));
        $this->dataImage['title'] = pathinfo($request->attachment->getClientOriginalName(), PATHINFO_FILENAME);
        $this->dataImage['image'] = $request->attachment;
        $this->dataModel['model'] = $assginment;
        $this->handleImageNameAndInsertInDb($this->dataImage,$this->dataModel);
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new AssignmentResource($assginment)
        ],Response::HTTP_CREATED);
    }

    public function destory(Request $request)
    {
        $assginment = Assignment::findOrFail($request->assignment_id);
        $this->dataModel['model'] = $assginment;
        $this->deleteImage(Assignment::DISK_NAME,$assginment->mediaFirst, $this->dataModel);
        $assginment->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
