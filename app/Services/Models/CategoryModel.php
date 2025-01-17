<?php

namespace App\Services\Models;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Subscription;
use App\Services\Utils\Imageable;
use App\Services\Utils\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        $categories = Category::with(['mediaFirst','fqas','instructor','modules' => function($q){
            return $q->with(['exams','lessons']);
        }])->Status()->latest();
        if(auth()->hasUser()){
            $categories = $categories->with(['subscription' => function($q){
                return $q->where('user_id',Auth::user()->id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
            }])->with(['modules' => function($q){
                return $q->with(['exams','lessons','subscription' => function($query){
                    return $query->where('user_id',Auth::user()->id)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
                }]);
            }]);
        }
        $categories = $categories->paginate();

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
        $categoy = $categoy->load(['mediaFirst','instructor']);
        return response()->json([
            'data' => new CategoryResource($categoy)
        ]);
    }

    public function showActiveCategory($categoryId)
    {
        $category =  Category::with(['mediaFirst','fqas','instructor','modules' => function($q){
            return $q->with('exams','lessons','attachments');
        }])->Status();

        if(auth()->hasUser()){
            $category = $category->with(['subscription' => function($q){
                return $q->where('user_id',Auth::user()->id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
            }])->with(['modules' => function($q){
                return $q->with(['exams','lessons','attachments','subscription' => function($query){
                    return $query->where('user_id',Auth::user()->id)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
                }]);
            }]);
        }
        $category = $category->findOrFail($categoryId);

        return response()->json([
            'data' => new CategoryResource($category)
        ]);
    }

    public function showActiveCategoriesSubscripted()
    {
        $subscriptionCategoryIds = Subscription::where('user_id',Auth::user()->id)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->pluck('category_id');
        $categories = Category::with(['mediaFirst','fqas','instructor','modules' => function($q){
            return $q->with('exams','lessons');
        }])->Status()->whereIn('id',$subscriptionCategoryIds)->get();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => CategoryResource::collection($categories),
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

    public function getAllCategoriesInSelections()
    {
        $categories = Category::Status()->get(['id','name']);
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $categories
        ]);
    }
}
