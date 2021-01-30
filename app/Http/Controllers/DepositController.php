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
        $deposits = Transaction::where('type', 'deposit')->get();

        return response()->json(
            [
                'totalDeposits' => $deposits->pluck('amount')->sum()
            ]
        );
    }

    public function show(Request $request)
    {
        $transactee_id = Transactee::where('user_id', $request->user()->id)
            ->where('status', 'receiver')->get('transaction_id')->first()->transaction_id;

        $transaction_query = Transaction::where('id', $transactee_id)->where('type', 'deposit');

        $deposit_amt =
            $transaction_query->first() !== null
            ? $transaction_query
            ->first()->amount
            : 0;

        return response()->json(
            [
                'deposit' => $deposit_amt
            ]
        );
    }
}
