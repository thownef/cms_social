<?php

namespace App\Actions\Post;

use App\Actions\Post\BaseAction;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DestroyAction extends BaseAction
{
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
            $this->postRepository->delete($id);
            $this->executeDeleteUpload($post);
            return $this->httpNoContent();
        });
    }
}