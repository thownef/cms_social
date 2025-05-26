<?php

namespace App\Http\Controllers\Api;

use App\Actions\Message\IndexAction;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $model)
    {
        //
    }
}
