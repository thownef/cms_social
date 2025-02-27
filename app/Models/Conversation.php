<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    protected $table = 'conversations';
    protected $fillable = [
        'group_id',
        'is_group',
        'last_message_id'
    ];

    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
