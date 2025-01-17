<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Services\Utils\Imageable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    use Imageable;

    public function index()
    {
        $settings = Setting::all();

        return response()->json([
            'message' => Response::HTTP_OK,
            'data' => SettingResource::collection($settings)
        ]);
    }

    public function show(Request $request)
    {
        $setting = Setting::where('id', $request->id)->first();

        return response()->json([
            'message' => Response::HTTP_OK,
            'data' => new SettingResource($setting)
        ]);
    }

    public function update(UpdateSettingRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);
        if($request->file('image')){
            $this->deleteImageFromLocalStorage(Setting::DISK_NAME, $setting->image);
            $newImage = $this->insertImage($setting->key, $request->image, Setting::DIR);
            $setting->update(array_merge($request->validated(),[
                'image' => $newImage
            ]));
        }else{

            $setting->update($request->validated());
        }


        return response()->json([
            'message' => Response::HTTP_OK,
            'data' => new SettingResource($setting)
        ],Response::HTTP_ACCEPTED);
    }
}
