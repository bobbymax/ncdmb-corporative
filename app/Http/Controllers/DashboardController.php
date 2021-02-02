<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Contribution;
use App\Models\Deposit;
use App\Models\Transactee;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\TransacteeResource;
use App\Http\Resources\DepositResource;
use App\Http\Resources\LoanResource;
use App\Http\Resources\TransactionResource;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = $this->userDashboard();
        $admin = $this->adminDashboard();
        // return collect([$admin])->pluck('totalContributions')[0];


        if (auth()->user()->hasRole(config('corporative.superAdmin'))) {
            return response()->json([
                'data' => compact('user', 'admin'),
                'status' => 'success',
                'message' => 'Fetched successfully!!'
            ], 200);
        }

        return response()->json([
            'data' => compact('user'),
            'status' => 'success',
            'message' => 'Fetched successfully!!'
        ], 200);
    }

    public function userDashboard()
    {
        $totalContributions = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'contribution')->sum('amount');

        // $totalDeposits = auth()->user()->deposits()->sum('amount');
        $totalDeposits = Deposit::where('user_id', auth()->user()->id)->where('paid', 1)->sum('amount');

        $availableBalance = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->sum('amount');

        $totalWithdrawals = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'withdrawal')->sum('amount');

        $totalLoans = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'loan')->sum('amount');

        $currentLoan = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'loan')->where('completed', false)->sum('amount');


        return compact('totalContributions', 'totalDeposits', 'availableBalance', 'totalWithdrawals', 'totalLoans', 'currentLoan');
    }

    private function adminDashboard()
    {
        $totalContributions = Transaction::where('type', 'contribution')->sum('amount');
        $totalDeposits = Deposit::where('paid', true)->sum('amount');
        $availableBalance = Transaction::where('completed', true)->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');
        $totalLoans = Transaction::where('type', 'loan')->sum('amount');
        $currentLoan = Transaction::where('type', 'loan')->where('completed', false)->sum('amount');

        return compact('totalContributions', 'totalDeposits', 'availableBalance', 'totalWithdrawals', 'totalLoans', 'currentLoan');
    }

    public function display($filter)
    {

        // $validator = Validator::make($request->all(), [
        //     'filter' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'data' => $validator->errors(),
        //         'status' => 'error',
        //         'message' => 'Please fix this errors'
        //     ], 422);
        // }

        return $this->normalise($filter);
    }

    public function adminDisplay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filter' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix this errors'
            ], 422);
        }

        return $this->adminNormaliser($request->filter);
    }

    private function normalise($data)
    {
        switch ($data) {
            case "available_balance":
                return TransacteeResource::collection(auth()->user()->transactions);
                break;

            case "deposit":
                return DepositResource::collection(auth()->user()->deposits);
                break;

            case "withdrawal":
                return auth()->user()->withdrawals;
                break;

            case "loan":
                return LoanResource::collection(auth()->user()->loans);
                break;

            case "contribution":
                return Transaction::whereHas('transactees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('type', 'contribution')->get();
                break;

            default:
                return Transaction::whereHas('transactees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('type', 'loan')->where('completed', false)->get();
                break;
        }
    }

    private function adminNormaliser($data)
    {
        switch ($data) {
            case "available":
                return TransacteeResource::collection(Transaction::where('completed', true)->get());
                break;

            case "deposits":
                return DepositResource::collection(Deposit::where('paid', true)->get());
                break;

            case "withdrawals":
                return Withdrawal::latest()->get();
                break;

            case "loans":
                return TransactionResource::collection(Transaction::where('type', 'loan')->latest()->get());
                break;

            case "contributions":
                return TransactionResource::collection(Transaction::where('type', 'contribution')->latest()->get());
                break;

            default:
                return TransactionResource::collection(Transaction::where('type', 'loan')->where('completed', false)->latest()->get());
                break;
        }
    }

    // public function show(Request $request)
    // {
    //     $transactee_id = Transactee::where('user_id', $request->user()->id)
    //         ->where('status', 'receiver')->get('transaction_id')->first()->transaction_id;

    //     $transaction_query = Transaction::where('id', $transactee_id)->where('type', 'deposit');

    //     $contribution_query = Transaction::where('id', $transactee_id)->where('type', 'contribution');

    //     $loan_query = Transaction::where('id', $transactee_id)->where('type', 'loan');

    //     $deposit_amt =
    //         $transaction_query->first() !== null
    //         ? $transaction_query
    //         ->first()->amount
    //         : 0;

    //     $contribution_amt =
    //         $contribution_query->first() !== null
    //         ? $contribution_query
    //         ->first()->amount
    //         : 0;

    //     $loan_amt =
    //         $loan_query->first() !== null
    //         ? $loan_query
    //         ->first()->amount
    //         : 0;

    //     return response()->json(
    //         [
    //             'deposit' => $deposit_amt,
    //             'contribution' => $contribution_amt,
    //             'loan' => $loan_amt,
    //             // 'member'=>new UserResource($request->user())
    //         ]
    //     );
    // }
}
