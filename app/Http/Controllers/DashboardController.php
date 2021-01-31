<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Contribution;
use App\Models\Transactee;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // $roles = $request->user()->roles;
        $deposits = Transaction::where('type', 'deposit')->get();
        $contributions = Transaction::where('type', 'contribution')->get();
        $loans = Transaction::where('type', 'loan')->get();

        return response()->json(
            [
                'totalDeposits' => $deposits->pluck('amount')->sum(),
                'totalContributions' => $contributions->pluck('amount')->sum(),
                'totalLoans' => $loans->pluck('amount')->sum(),
            ]
        );
    }

    public function show(Request $request)
    {
        $transactee_id = Transactee::where('user_id', $request->user()->id)
            ->where('status', 'receiver')->get('transaction_id')->first()->transaction_id;

        $transaction_query = Transaction::where('id', $transactee_id)->where('type', 'deposit');

        $contribution_query = Transaction::where('id', $transactee_id)->where('type', 'contribution');

        $loan_query = Transaction::where('id', $transactee_id)->where('type', 'loan');

        $deposit_amt =
            $transaction_query->first() !== null
            ? $transaction_query
            ->first()->amount
            : 0;

        $contribution_amt =
            $contribution_query->first() !== null
            ? $contribution_query
            ->first()->amount
            : 0;

        $loan_amt =
            $loan_query->first() !== null
            ? $loan_query
            ->first()->amount
            : 0;

        return response()->json(
            [
                'deposit' => $deposit_amt,
                'contribution' => $contribution_amt,
                'loan' => $loan_amt,
                // 'member'=>new UserResource($request->user())
            ]
        );
    }
}
