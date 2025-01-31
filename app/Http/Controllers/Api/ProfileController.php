<?php

namespace App\Http\Controllers\Api;

use App\Actions\Profile\ShowAction;
use App\Actions\Profile\UpdateAction;
use App\Actions\Profile\UploadImageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\UpdateRequest;
use App\Http\Requests\Api\Profile\UploadImageRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * @param Profile $profile
     * @param ShowAction $action
     * @return JsonResponse
     */
    public function show(Profile $profile, ShowAction $action)
    {
        return $action($profile->id);
    }

    /**
     * @param UpdateRequest $request
     * @param Profile $profile
     * @param UpdateAction $action
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, UpdateAction $action)
    {
        $profile = auth()->user()->profile;
        return $action($profile->id, $request->validated());
    }

    public function uploadImage(UploadImageRequest $request, UploadImageAction $action)
    {
        $profile = auth()->user()->profile;
        return $action($profile->id, $request->validated());
    }
}
