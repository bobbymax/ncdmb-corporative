<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transactee;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // $roles = $request->user()->roles;
        $deposits = Transaction::where('type', 'deposits')->get();

        return response()->json(
            [
                'totalDeposits' => $deposits->pluck('amount')->sum()
            ]
        );
    }

    public function show(Request $request)
    {
        $transation_query = Transactee::where('user_id', $request->user()->id)
            ->where('status', 'receiver');

        $deposit_amt =
            $transation_query->first() !== null
            ? $transation_query
            ->first()->transaction->amount
            : 0;

        return response()->json(
            [
                'deposit' => $deposit_amt
            ]
        );
    }
}
