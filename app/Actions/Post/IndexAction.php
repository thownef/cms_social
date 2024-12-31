<?php

namespace App\Actions\Post;

use App\Actions\Post\BaseAction;
use App\Transformers\PostTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class IndexAction extends BaseAction
{
    public function __invoke(): JsonResponse
    {
        return DB::transaction(function () {
            $posts = $this->postRepository->queryBuilder()->paginate(5);

            return $this->httpOK($posts, PostTransformer::class);
        });
    }
}