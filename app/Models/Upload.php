<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Observers\UploadObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(UploadObserver::class)]
class Upload extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $fillable = [
        'uploadable_id',
        'uploadable_type',
        'name',
        'link',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function uploadable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeCollection($query)
    {
        return $query->whereHasMorph('uploadable', '*', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }
}
