<?php

namespace App\Services\Utils;

use Illuminate\Support\Facades\Storage;

trait Imageable {

    public function handleImageNameAndInsertInDb($dataImage, $dataModel)
    {
        $newImage = $this->insertImage($dataImage['title'], $dataImage['image'],$dataImage['dir']);
        $this->insertImageInMeddiable($dataModel['model'], $newImage,$dataImage['image'],$dataModel['relation']);
    }

    public function insertMultipleImage($imageFound, $title, $model,$dir, $relation = 'attachments')
    {
        $sort_image = 0;
        foreach ($imageFound as $image) {
            $data =  $this->generationImageName($image, $title, $sort_image);
            $image->move(public_path($dir), $data['file_name']);
            $this->saveImage($model, $data, $relation);
            $sort_image++;
        }
    }

    public function deleteIMageFromLoaclStorage($diskName,$old_images)
    {
        foreach ($old_images as $image) {
            Storage::disk($diskName)->delete($image->file_name);
        }
    }

    public function deleteImage($diskName,$old_image)
    {
        if(isset($old_image->file_name)){
            Storage::disk($diskName)->delete($old_image->file_name);
        }
    }

    private function insertImage($title, $image, $dir)
    {
        $newImage  = $title . '_' . date('Y-m-d-H-i-s') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($dir), $newImage);
        return $newImage;
    }

    private function insertImageInMeddiable($model, $newImage,
    $oldImage,$relation='mediaFirst')
    {
        if (!is_object($model)) {
            $model = app($model);
        }

        $file_type = $this->getTypeOfFile($oldImage);

        $model->$relation()->create([
            'file_name'  => $newImage,
            'file_sort' => 1,
            'file_status' => 1,
            'file_type' => $file_type
        ]);
    }

    private  function generationImageName($imageNew, $slug, $sort_image)
    {
        $data['file_name'] = $slug . $sort_image . '_' . date('Y-m-d-H-i-s') . '.' . $imageNew->getClientOriginalExtension();
        $data['file_sort'] = $sort_image;
        $data['file_type'] = $this->getTypeOfFile($imageNew);
        return $data;
    }

    private function saveImage($model, $data, $relation)
    {
        $model->$relation()->create([
            'file_name'  => $data['file_name'],
            'file_sort' => $data['file_sort'],
            'file_type' => $data['file_type'],
            'file_status' => 1,
        ]);
    }

    private function getTypeOfFile($image)
    {
        switch ($image->getClientOriginalExtension()) {
            case 'pdf':
                return 'document';
                break;
            default:
                return 'image';
                break;
        }
    }
}
