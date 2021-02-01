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
        $deposits_online = Transaction::where('type', 'online')->get()->pluck('amount')->sum();
        $deposits_bank = Transaction::where('type', 'bank')->get()->pluck('amount')->sum();
        $deposits = $deposits_online + $deposits_bank;
        $contributions = Transaction::where('type', 'contribution')->get();
        $loans = Transaction::where('type', 'loan')->get();
        $withdrawals = Transaction::where('type', 'withdrawal')->get();
        $availBalance = Transaction::all()->pluck('amount')->sum();

        return response()->json(
            [
                'totalDeposits' => $deposits,//->pluck('amount')->sum(),
                'totalContributions' => $contributions->pluck('amount')->sum(),
                'totalLoans' => $loans->pluck('amount')->sum(),
                'totalWithdrawals' => $withdrawals->pluck('amount')->sum(),
                'availableBalance' => $availBalance
            ]
        );
    }

    public function show(Request $request)
    {
        $transactee_id = Transactee::where('user_id', $request->user()->id)
            ->where('status', 'receiver')->get('transaction_id')->first()->transaction_id;

        $deposit_query = Transaction::where('id', $transactee_id)->where('type', 'deposit');

        $contribution_query = Transaction::where('id', $transactee_id)->where('type', 'contribution');

        $loan_query = Transaction::where('id', $transactee_id)->where('type', 'loan');

        $withdrawal_query = Transaction::where('id', $transactee_id)->where('type', 'withdrawal');

        $available_bal_amt = Transaction::where('id', $transactee_id)->pluck('amount')->sum();

        $deposit_amt =
            $deposit_query->first() !== null
            ? $deposit_query
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

        $withdrawal_amt =
            $withdrawal_query->first() !== null
            ? $withdrawal_query
            ->first()->amount
            : 0;

        return response()->json(
            [
                'totalDeposits' => $deposit_amt,
                'totalContributions' => $contribution_amt,
                'totalLoans' => $loan_amt,
                'totalWithdrawals' => $withdrawal_amt,
                'currentLoan' => 0, //$withdrawal_amt,
                'availableBalance' => $available_bal_amt //$withdrawal_amt,
                // 'member'=>new UserResource($request->user())
            ]
        );
    }
}
