<?php

namespace App\Actions\Profile;

use App\Actions\Profile\BaseAction;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UploadImageAction extends BaseAction
{

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(int $id, array $data): JsonResponse
    {
        return DB::transaction(function () use ($id, $data) {
            $postRepository = resolve(PostRepository::class);
            $post = $postRepository->create($data);
            $this->executeUpload($post, $data, 'avatar');
        });
    }
}
