<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Contribution;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Fund;
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

use DB;

/**
     * @OA\Get(
     *     path="/dashboard/details",
     *     tags={"Dashboard"},
     *      summary="Dashboard Route",
     *     description="Returns Dashboard Info",
     *     operationId="dashBoard",
     *
     *     @OA\Response(
     *         response=200,
     *         description="User Dashboard Info",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Please fix these errors"
     *      ),
       * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     * )
     *     )
     * )
     */



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


        // if (auth()->user()->hasRole(config('corporative.superAdmin'))) {
        if (auth()->user()->roles->count() > 1) {
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

        $availableBalance = Wallet::where('user_id', auth()->user()->id)->first();

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
        $totalContributions = Contribution::sum('fee');
        $totalDeposits = Deposit::where('paid', true)->sum('amount');
        $availableBalance = Wallet::sum('current');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');
        $totalLoans = 0;
        $currentLoan = Transaction::where('type', 'loan')->where('completed', false)->sum('amount');
        $registeredMembers = User::where('type', 'member')->count();
        $approvedBudgetAmount = Fund::sum('approved_amount');

        return compact('totalContributions', 'totalDeposits', 'availableBalance', 'totalWithdrawals', 'totalLoans', 'currentLoan', 'registeredMembers', 'approvedBudgetAmount');
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
