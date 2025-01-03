<?php

namespace App\Models;

use App\Models\Traits\HasUserContext;
use App\Observers\FriendRequestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([FriendRequestObserver::class])]
class FriendRequest extends Model
{
    use HasFactory, HasUserContext;

    protected $table = 'friend_requests';

    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
        'accepted_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
