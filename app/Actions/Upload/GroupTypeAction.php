<?php

namespace App\Actions\Upload;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\CollectionTransform;
use App\Transformers\UploadTransformer;
use Illuminate\Support\Facades\DB;

class GroupTypeAction extends BaseAction
{
    use HasPerPageRequest;
    public function __invoke()
    {
        return DB::transaction(function () {
            $uploads = $this->uploadRepository->getGroupType();
            dd($uploads);
            $collections = (new CollectionTransform())->transform($uploads);

            return $this->httpOK($collections);
        });
    }
}
