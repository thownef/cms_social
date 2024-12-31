<?php

namespace App\Observers;

use App\Facades\S3Service;
use App\Models\Upload;

class UploadObserver
{
    /**
     * Handle the Upload "deleted" event.
     */
    public function deleted(Upload $upload): void
    {
        S3Service::deleteFile($upload->link);
    }
}
