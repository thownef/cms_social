<?php

namespace App\Transformers;

use App\Models\Message;
use Flugg\Responder\Transformers\Transformer;

class MessageTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Message $message
     * @return array
     */
    public function transform(Message $message)
    {
        return [
            'id' => (int) $message->id,
            'message' => $message->message,
            'name' => $message->user->profile->first_name . ' ' . $message->user->profile->last_name,
            'avatar' => $message->user->profile->avatar,
            'updated_at' => $message->updated_at,
        ];
    }
}
