<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\WorkHistory\DestroyAction;
use App\Actions\WorkHistory\StoreAction;
use App\Actions\WorkHistory\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WorkHistory\StoreRequest;
use App\Http\Requests\Api\WorkHistory\UpdateRequest;
use App\Models\WorkHistory;
use Illuminate\Http\JsonResponse;

class WorkHistoryController extends Controller
{
    /**
     * Summary of store
     * @param \App\Http\Requests\Api\WorkHistory\StoreRequest $request
     * @param \App\Actions\WorkHistory\StoreAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, StoreAction $action): JsonResponse
    {
        return $action($request->validated());
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Api\WorkHistory\UpdateRequest $request
     * @param \App\Models\WorkHistory $workHistory
     * @param \App\Actions\WorkHistory\UpdateAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, WorkHistory $workHistory, UpdateAction $action): JsonResponse
    {
        return $action($workHistory->id, $request->validated());
    }

    /**
     * Summary of destroy
     * @param \App\Models\WorkHistory $workHistory
     * @param \App\Actions\WorkHistory\DestroyAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(WorkHistory $workHistory, DestroyAction $action): JsonResponse
    {
        return $action($workHistory->id);
    }
}   
