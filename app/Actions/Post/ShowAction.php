<?php

namespace App\Actions\Post;

use App\Actions\Post\BaseAction;
use App\Models\Post;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\PostTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ShowAction extends BaseAction
{
    use HasPerPageRequest;

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        return DB::transaction(function () use ($id) {
            /**
             * @var Post $post
             */
            $post = $this->postRepository->find($id);

            return $this->httpOK($post, PostTransformer::class);
        });
    }
}