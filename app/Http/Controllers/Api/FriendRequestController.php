<?php

namespace App\Http\Controllers\Api;

use App\Actions\FriendRequest\IndexAction;
use App\Actions\FriendRequest\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FriendRequest\StoreRequest;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $action)
    {
        return $action();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, StoreAction $action)
    {
        return $action($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
