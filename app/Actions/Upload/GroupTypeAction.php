<?php

namespace App\Actions\Upload;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\CollectionTransform;
use Illuminate\Support\Facades\DB;

class GroupTypeAction extends BaseAction
{
    use HasPerPageRequest;
    public function __invoke()
    {
        return DB::transaction(function () {
            $uploads = $this->uploadRepository->getGroupType();

            return $this->httpOK($uploads, CollectionTransform::class);
        });
    }
}
