<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\WorkHistory\{IndexAction, ShowAction, StoreAction, UpdateAction, DestroyAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WorkHistory\{IndexRequest, StoreRequest, UpdateRequest};
use App\Models\WorkHistory;
use Illuminate\Http\JsonResponse;

class WorkHistoryController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\WorkHistory\IndexAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexAction $action): JsonResponse 
    {
        return $action();
    }

    /** 
     * 
     */

    public function store(StoreRequest $request, StoreAction $action): JsonResponse
    {
        return $action($request->validated());
    }

    // public function show(WorkHistory $workHistory, ShowAction $action): JsonResponse
    // {
    //     return $action($workHistory->id);
    // }

    // public function update(UpdateRequest $request, WorkHistory $workHistory, UpdateAction $action): JsonResponse
    // {
    //     return $action($workHistory->id, $request->validated());
    // }

    // public function destroy(WorkHistory $workHistory, DestroyAction $action): JsonResponse
    // {
    //     return $action($workHistory->id);
    // }
}
