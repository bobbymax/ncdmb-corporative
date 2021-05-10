<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DependencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function budgetHeadCategory()
    {
        return response()->json([
            'data' => config('corporative.category'),
            'status' => 'success',
            'message' => 'List of Budget Head Types'
        ]);
    }
}
