<?php

namespace App\Models\Traits;

trait HasProfileContext
{
    public static function bootHasProfileContext()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->profile_id = auth()->user()->profile->id;
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->profile_id = auth()->user()->profile->id;
            }
        });
    }
} 
