<?php

namespace App\Repositories\Traits;

use App\Facades\S3Service;

trait HasUpload
{
    public function upload($model, $file = null): void
    {
        if (is_null($file) || ! method_exists($model, 'uploadable')) {
            return;
        }

        if ($model->uploadable()->exists()) {
            $model->uploadable->delete();
        }

        $fileName = date('YmdHis').'_'.$file->getClientOriginalName();
        $link = S3Service::putFile($fileName, $file->getContent(), $model->uploadFolder ?? '');
        $model->uploadable()->create(['name' => $fileName, 'link' => $link]);
    }

    public function uploadMultiple($model, $files = []): void 
    {
        if (empty($files) || !method_exists($model, 'uploadable')) {
            return;
        }

        if ($model->uploadable()->exists()) {
            $model->uploadable->each(function ($upload) {
                $upload->delete();
            });
        }

        foreach ($files as $file) {
            $fileName = date('YmdHis') . '_' . $file->getClientOriginalName();
            $link = S3Service::putFile($fileName, $file->getContent(), $model->uploadFolder ?? '');
            $model->uploadable()->create(['name' => $fileName, 'link' => $link]);
        }
    }

    public function deleteUpload($model): void
    {
        if ($model->uploadable()->exists()) {
            $model->uploadable->delete();
        }
    }

    public function deleteUploadMultiple($model): void
    {
        if ($model->uploadable()->exists()) {
            $model->uploadable->each(function ($upload) {
                $upload->delete();
            });
        }
    }
}