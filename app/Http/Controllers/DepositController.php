<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        // $roles = $request->user()->roles;
        $deposits = Transaction::where('type', 'deposits')->get();
        $arr = [];
        foreach ($deposits as $key => $value) {
            array_push($arr, $deposits->pluck('amount'));
        }
        $arr = collect($arr)->flatten();
        return response()->json(
            [
                'totalDeposits' => $arr->sum()
            ]
        );
    }

    public function show($id)
    {
        //
    }
}
