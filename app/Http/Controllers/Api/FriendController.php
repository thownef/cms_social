<?php

namespace App\Http\Controllers\Api;

use App\Actions\Friend\IndexAction;
use App\Actions\Friend\ShowAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $action)
    {
        return $action();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, ShowAction $action)
    {
        return $action($id);
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
