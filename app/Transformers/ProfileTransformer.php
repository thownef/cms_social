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
    protected $relations = ['user', 'workHistories'];

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
        return [
            'id' => $profile->id,
            'gender' => $profile->gender,
            'date_of_birth' => $profile->date_of_birth,
            'location' => $profile->location,
            'biography' => $profile->biography,
            'created_at' => Carbon::parse($profile->created_at)->format('Y/m/d H:i:s'),
            'updated_at' => Carbon::parse($profile->updated_at)->format('Y/m/d H:i:s'),
        ];
    }

    public function includeProfile(User $user)
    {
        return $this->item($user->profile, new ProfileTransformer);
    }

    public function includeWorkHistories(Profile $profile)
    {
        return $this->collection($profile->workHistories, new WorkHistoryTransformer);
    }
}
