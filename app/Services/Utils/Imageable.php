<?php

namespace App\Services\Utils;

use Illuminate\Support\Facades\Storage;

trait Imageable {

    public function handleImageNameAndInsertInDb($dataImage, $dataModel)
    {
        $newImage = $this->insertImage($dataImage['title'], $dataImage['image'],$dataImage['dir']);
        $this->insertImageInMeddiable($dataModel['model'], $newImage, $dataModel['relation']);
    }

    private function insertImage($title, $image, $dir)
    {
        $newImage  = $title . '_' . date('Y-m-d-H-i-s') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($dir), $newImage);
        return $newImage;
    }

    private function insertImageInMeddiable($model, $newImage, $relation='mediaFirst')
    {
        if (!is_object($model)) {
            $model = app($model);
        }

        $model->$relation()->create([
            'file_name'  => $newImage,
            'file_sort' => 1,
            'file_status' => 1,
        ]);
    }

    public function deleteImage($diskName,$old_image)
    {
        Storage::disk($diskName)->delete($old_image->file_name);
    }

}
