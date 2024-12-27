<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Profile\ShowAction;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @param Profile $profile
     * @param UpdateAction $action
     * @return JsonResponse
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

}
