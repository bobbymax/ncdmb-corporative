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

        return response()->json(
            [
                'totalDeposits' => $deposits->pluck('amount')->sum()
            ]
        );
    }

    public function show($id)
    {
        //
    }
}
