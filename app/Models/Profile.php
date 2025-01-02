<?php

namespace App\Models;

use App\Models\Traits\HasUploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Profile extends Model
{
    use HasFactory, HasUploadable;
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'location',
        'biography',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workHistory(): HasMany
    {
        return $this->hasMany(WorkHistory::class);
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Upload::class, 'uploadable')
            ->where('type', 'avatar');
    }

    protected function cover(): MorphOne
    {
        return $this->morphOne(Upload::class, 'uploadable')
            ->where('type', 'cover');
    }
}
