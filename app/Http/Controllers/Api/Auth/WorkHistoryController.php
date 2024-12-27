<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\WorkHistory\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WorkHistory\StoreRequest;
use App\Models\WorkHistory;
use Illuminate\Http\Request;

class WorkHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, StoreAction $action)
    {
        return $action($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkHistory $workHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkHistory $workHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkHistory $workHistory)
    {
        //
    }
}
