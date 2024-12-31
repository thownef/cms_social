<?php

namespace App\Actions\Post;

use App\Repositories\PostRepository;
use App\Supports\Traits\HasTransformer;
use Illuminate\Database\Eloquent\Model;

abstract class BaseAction
{
    use HasTransformer;

    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    protected function executeUpload(Model $model, $files = null): void
    {
        $this->postRepository->uploadMultiple($model, $files);
    }

    protected function executeDeleteUpload(Model $model): void
    {
        $this->postRepository->deleteUploadMultiple($model);
    }
}
