<?php

namespace App\Transformers;

use App\Models\User;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class UserTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = ['profile'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'created_at' => Carbon::parse($user->created_at)->format('Y/m/d H:i:s'),
            'updated_at' => Carbon::parse($user->updated_at)->format('Y/m/d H:i:s'),
        ];
    }

    public function includeProfile(User $user)
    {
        return $this->item($user->profile, new ProfileTransformer);
    }
}
