<?php

namespace App\Models\Traits;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasUploadMultiple
{
    protected function uploadFolder(): Attribute
    {
        $folder = '';
        if (method_exists($this, 'user')) {
            $folder .= class_basename($this->user()->getRelated()) . DIRECTORY_SEPARATOR;
        }

        if (! empty($this->user_id)) {
            $folder .= $this->user_id . DIRECTORY_SEPARATOR;
        }
        $folder .= class_basename($this);

        return Attribute::make(get: fn() => strtolower($folder));
    }

    public function uploadable(): MorphMany
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }
}
