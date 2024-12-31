<?php

namespace App\Actions\Upload;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\UploadTransformer;
use Illuminate\Support\Facades\DB;

class IndexAction extends BaseAction
{
    use HasPerPageRequest;
    public function __invoke()
    {
        return DB::transaction(function () {
            $uploads = $this->uploadRepository->queryBuilder()->collection()->paginate($this->getPerPage());
            return $this->httpOk($uploads, UploadTransformer::class);
        });
    }
}
