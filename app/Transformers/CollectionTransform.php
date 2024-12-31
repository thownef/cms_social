<?php

namespace App\Transformers;

use Flugg\Responder\TransformBuilder;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Database\Eloquent\Collection;

class CollectionTransform extends Transformer
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

    protected $typeMapping = [
        'App\\Models\\Profile' => 'profiles',
        'App\\Models\\Post' => 'posts',
    ];

    public function transform(Collection $collection)
    {
        $uploadList = $collection->groupBy('uploadable_type')->map(function ($items, $type) {
            return $items->map(function ($item) {
                return app(TransformBuilder::class)
                    ->resource($item, new UploadTransformer())
                    ->transform()['data'] ?? [];
            });
        })->mapWithKeys(function ($items, $type) {
            return [$this->typeMapping[$type] ?? class_basename($type) => $items];
        });

        return [
            $uploadList
        ];
    }
}
