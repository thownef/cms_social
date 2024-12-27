<?php

namespace App\Actions\Profile;

use App\Repositories\ProfileRepository;
use App\Supports\Traits\HasTransformer;

abstract class BaseAction
{
    use HasTransformer;

    protected ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
}
