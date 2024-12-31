<?php

namespace App\Actions\Profile;

use App\Repositories\ProfileRepository;
use App\Supports\Traits\HasTransformer;
use Illuminate\Database\Eloquent\Model;

abstract class BaseAction
{
    use HasTransformer;

    protected ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    protected function executeUpload(Model $model, $files = null, $type = null): void
    {
        $this->profileRepository->upload($model, $files, $type);
    }
}
