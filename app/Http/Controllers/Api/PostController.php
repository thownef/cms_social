<?php

namespace App\Http\Controllers\Api;

use App\Actions\Post\DestroyAction;
use App\Actions\Post\IndexAction;
use App\Actions\Post\ShowAction;
use App\Actions\Post\StoreAction;
use App\Actions\Post\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * @param IndexAction $action
     * @return JsonResponse
    */
    public function index(IndexAction $action)
    {
        return $action();
    }

    /**
     * @param StoreRequest $request
     * @param StoreAction $action
     * @return JsonResponse
    */
    public function store(StoreRequest $request, StoreAction $action)
    {
        return $action($request->validated());
    }

    /**
     * @param Post $post
     * @param ShowAction $action
     * @return JsonResponse
    */
    public function show(Post $post, ShowAction $action)
    {
        return $action($post->id);
    }

    /**
     * @param UpdateRequest $request
     * @param Post $post
     * @param UpdateAction $action
     * @return JsonResponse
    */
    public function update(UpdateRequest $request, Post $post, UpdateAction $action)
    {
        return $action($post->id, $request->validated());
    }

    /**
     * @param int $id
     * @param DestroyAction $action
     * @return JsonResponse
    */
    public function destroy(int $id, DestroyAction $action)
    {
        return $action($id);
    }
}
