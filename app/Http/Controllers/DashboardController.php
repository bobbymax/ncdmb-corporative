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

    private function userDashboard()
    {
        $contributions = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'contribution')->sum('amount');

        $deposits = auth()->user()->deposits()->sum('amount');

        $available = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->sum('amount');

        $withdrawals = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'withdrawal')->sum('amount');

        $loans = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'loan')->sum('amount');

        $currentLoans = Transaction::whereHas('transactees', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->where('type', 'loan')->where('completed', false)->sum('amount');


        return compact('contributions', 'deposits', 'available', 'withdrawals', 'loans', 'currentLoans');
    }

    private function adminDashboard()
    {
        $contributions = Transaction::where('type', 'contribution')->sum('amount');
        $deposits = Deposit::where('paid', true)->sum('amount');
        $available = Transaction::where('completed', true)->sum('amount');
        $withdrawals = Transaction::where('type', 'withdrawal')->sum('amount');
        $loans = Transaction::where('type', 'loan')->sum('amount');
        $currentLoans = Transaction::where('type', 'loan')->where('completed', false)->sum('amount');

        return compact('contributions', 'deposits', 'available', 'withdrawals', 'loans', 'currentLoans');
    }

    public function display(Request $request)
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

        return $this->normalise($request->filter);
        
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
            case "available":
                return TransacteeResource::collection(auth()->user()->transactions);
                break;

            case "deposits":
                return DepositResource::collection(auth()->user()->deposits);
                break;

            case "withdrawals":
                return auth()->user()->withdrawals;
                break;

            case "loans":
                return LoanResource::collection(auth()->user()->loans);
                break;

            case "contributions":
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
