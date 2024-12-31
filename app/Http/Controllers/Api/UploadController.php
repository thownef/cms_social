<?php

namespace App\Http\Controllers\Api;

use App\Actions\Upload\GroupTypeAction;
use App\Actions\Upload\IndexAction;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $action)
    {
        return $action();
    }

    public function groupType(GroupTypeAction $action)
    {
        return $action();
    }
}
