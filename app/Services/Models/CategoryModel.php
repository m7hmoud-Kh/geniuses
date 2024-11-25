<?php

namespace App\Services\Models;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Utils\Imageable;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryModel extends Model
{

    use Paginatable, Imageable;

    public $dataImage = [
        'title' => '',
        'image' => '',
        'dir' => Category::DIR
    ];
    public $dataModel = [
        'model' => '',
        'relation' => 'mediaFirst'
    ];

    public function getAllCategories()
    {
        $categories = Category::with('mediaFirst')->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => CategoryResource::collection($categories),
            'meta' => $this->getPaginatable($categories)
        ]);
    }

    public function getAllActiveCategories()
    {
        $categories = Category::with('mediaFirst')->Status()->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => CategoryResource::collection($categories),
            'meta' => $this->getPaginatable($categories)
        ]);
    }

    public function storeCategory(Request $request)
    {
        $category = Category::create($request->except(['image']));
        $this->dataImage['title'] = $request->name;
        $this->dataImage['image'] = $request->image;
        $this->dataModel['model'] = $category;
        $this->handleImageNameAndInsertInDb($this->dataImage,$this->dataModel);
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new CategoryResource($category)
        ],Response::HTTP_CREATED);
    }

    public function showCategory(Category $categoy)
    {
        $categoy = $categoy->load(['mediaFirst','fqa']);
        return response()->json([
            'data' => new CategoryResource($categoy)
        ]);
    }

    public function showActiveCategory($categoryId)
    {
        $category = Category::with(['mediaFirst','fqas','modules'])->findOrFail($categoryId);
        return response()->json([
            'data' => new CategoryResource($category)
        ]);
    }

    public function updateCategory(Request $request,Category $category)
    {
        $category->update($request->except(['image']));
        if($request->file('image')){
            $this->dataImage['title'] = $request->name ?? $category->name;
            $this->dataImage['image'] = $request->image;
            $this->dataModel['model'] = $category;
            $this->deleteImage(Category::DISK_NAME,$category->mediaFirst,$this->dataModel);
            $this->handleImageNameAndInsertInDb($this->dataImage, $this->dataModel);
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new CategoryResource($category)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryCategory($category)
    {
        $this->dataModel['model'] = $category;
        $this->deleteImage(Category::DISK_NAME,$category->mediaFirst, $this->dataModel);
        $category->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
