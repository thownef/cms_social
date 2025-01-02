<?php

namespace App\Actions\Profile;

use App\Repositories\ProfileRepository;
use App\Repositories\PostRepository;
use App\Supports\Traits\HasTransformer;
use Illuminate\Database\Eloquent\Model;

abstract class BaseAction
{
    use HasTransformer;

    protected ProfileRepository $profileRepository;
    protected PostRepository $postRepository;

    public function __construct(ProfileRepository $profileRepository, PostRepository $postRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->postRepository = $postRepository;
    }

    protected function executeUpload(Model $model, $file = null, $type = null): void
    {
        $this->postRepository->upload($model, $file, $type);
    }

    protected function executeUploadImage(Model $model, $upload, string $type): void
    {
        if ($model->uploadable()->exists() && $model->uploadable->type === $type) {
            $model->uploadable->delete();
        }
        $model->uploadable()->create([
            'name' => $upload['name'],
            'link' => $upload['link'],
            'type' => $type,
        ]);
    }
}
