<?php

namespace App\Models;

use App\Enums\RequestFriendEnum;
use App\Models\Traits\HasCheckAccess;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, HasCheckAccess, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'login_type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function sendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'user_id', 'id')
            ->with('sender.profile')
            ->where('status', RequestFriendEnum::PENDING)
            ->whereNull('accepted_at');
    }

    public function receivedRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'friend_id', 'id')
            ->with('receiver.profile')
            ->where('status', RequestFriendEnum::PENDING)
            ->whereNull('accepted_at');
    }

    public function friends(): HasMany
    {
        return $this->hasMany(Friend::class, 'user_id', 'id');
    }

    public function friendSettings(): HasOne
    {
        return $this->hasOne(FriendSetting::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_users');
    }
}
