<?php

namespace App\Services\Models;

use App\Http\Resources\FqaResource;
use App\Models\Fqa;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FqaModel extends Model
{
    use paginatable;

    public function getAllFqa()
    {
        $categories = Fqa::with('category')->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => FqaResource::collection($categories),
            'meta' => $this->getPaginatable($categories)
        ]);
    }

    public function storeFqa(Request $request)
    {
        $category = Fqa::create($request->validated());
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new FqaResource($category)
        ],Response::HTTP_CREATED);
    }

    public function showFqa(Fqa $fqa)
    {
        $fqa = $fqa->load(['category']);
        return response()->json([
            'data' => new FqaResource($fqa)
        ]);
    }

    public function updateFqa(Request $request,Fqa $fqa)
    {
        $fqa->update($request->validated());
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new FqaResource($fqa)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryFqa($fqa)
    {
        $fqa->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
