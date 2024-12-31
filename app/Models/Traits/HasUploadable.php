<?php

namespace App\Models\Traits;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasUploadable
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

    public function uploadable(): MorphOne
    {
        return $this->morphOne(
            related: Upload::class,
            name: 'uploadable'
        );
    }
}
