<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class ProfileTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = ['user', 'workHistory'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Profile $profile
     * @return array
     */
    public function transform(Profile $profile)
    {
        // dd($profile->avatar);
        return [
            'id' => $profile->id,
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'gender' => $profile->gender,
            'date_of_birth' => $profile->date_of_birth,
            'location' => $profile->location,
            'biography' => $profile->biography,
            'created_at' => Carbon::parse($profile->created_at)->format('Y/m/d H:i:s'),
            'updated_at' => Carbon::parse($profile->updated_at)->format('Y/m/d H:i:s'),
            'avatar' => (new UploadTransformer)->transform($profile->avatar),
            'cover' => (new UploadTransformer)->transform($profile->cover),
        ];
    }

    public function includeProfile(User $user)
    {
        return $this->item($user->profile, new ProfileTransformer);
    }

    public function includeWorkHistory(Profile $profile)
    {
        return $this->collection($profile->workHistory, new WorkHistoryTransformer);
    }
}
