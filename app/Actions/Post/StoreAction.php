<?php

namespace App\Actions\Post;

use App\Actions\Post\BaseAction;
use App\Models\Post;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\PostTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreAction extends BaseAction
{
    use HasPerPageRequest;

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            /**
             * @var Post $post
             */
            $post = $this->postRepository->create($data);
            $files = data_get($data, 'files', []);
            if (!empty($files)) {
                $this->executeUpload($post, $files);
            }

            return $this->httpOK($post, PostTransformer::class);
        });
    }
}