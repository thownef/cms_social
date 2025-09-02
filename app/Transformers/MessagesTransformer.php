<?php

namespace App\Transformers;

use App\Models\Message;
use Flugg\Responder\Transformers\Transformer;

class MessagesTransformer extends Transformer
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
            'id' => $message->id,
            'user_id' => $message->user_id,
            'conversation_id' => $message->conversation_id,
            'message' => $message->message,
            'name' => $message->user->profile->first_name . ' ' . $message->user->profile->last_name,
            'avatar' => $message->user->profile->avatar,
            'created_at' => $message->created_at,
            'updated_at' => $message->updated_at,
        ];
    }
}
