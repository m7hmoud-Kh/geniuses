<?php

namespace App\Services\Models;

use App\Http\Resources\InstructorResource;
use App\Models\Instructor;
use App\Services\Utils\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstructorModel extends Model
{

    use Paginatable;

    public function getAllInstructor()
    {
        $instructors = Instructor::latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => InstructorResource::collection($instructors),
            'meta' => $this->getPaginatable($instructors)
        ]);
    }

    public function storeInstructor(Request $request)
    {
        $instructor = Instructor::create($request->validated());
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new InstructorResource($instructor)
        ],Response::HTTP_CREATED);
    }

    public function showInstructor(Instructor $instructor)
    {
        return response()->json([
            'data' => new InstructorResource($instructor)
        ]);
    }

    public function updateInstructor(Request $request,Instructor $instructor)
    {
        $instructor->update($request->validated());
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new InstructorResource($instructor)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryInstructor($instructor)
    {
        $instructor->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
