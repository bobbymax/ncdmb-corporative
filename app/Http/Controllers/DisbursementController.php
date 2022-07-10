<?php

namespace App\Http\Controllers;

use App\Models\Disbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DisbursementResource;

class DisbursementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $disbursements = Disbursement::all();

        if ($disbursements->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data was found!'
            ], 200);
        }
        return response()->json([
            'data' => DisbursementResource::collection($disbursements),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'budget_head_id' => 'required|integer',
            'chart_of_account_id' => 'required|integer',
            'payment_type' => 'required|string|in:member-payment,staff-payment,third-party,custom',
            // 'type' => 'required|string|in:loan,expense,salary,contribution,dividend,other',
            'code' => 'required|string|unique:disbursements',
            'beneficiary' => 'required|string|max:255',
            'description' => 'required',
            'amount' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $disbursement = Disbursement::create([
            'user_id' => auth()->user()->id,
            'budget_head_id' => $request->budget_head_id,
            'chart_of_account_id' => $request->chart_of_account_id,
            'payment_type' => $request->payment_type,
            'code' => $request->code,
            'beneficiary' => $request->beneficiary,
            'description' => $request->description,
            'amount' => $request->amount,
            'loan_id' => $request->loan_id,
        ]);

        $fund = $disbursement->budgetHead->fund($this->getBudgetYear());

        if ($fund) {
            $fund->booked_expenditure += $disbursement->amount;
            $fund->booked_balance -= $disbursement->amount;
            $fund->save();

            if ($disbursement->loan_id > 0) {
                $disbursement->loan->status = "disbursed";
                $disbursement->loan->save();
            }
        }

        return response()->json([
            'data' => new DisbursementResource($disbursement),
            'status' => 'success',
            'message' => 'Expenditure has been created successfully!!'
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($disbursement)
    {
        $disbursement = Disbursement::find($disbursement);

        if (! $disbursement) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }
        return response()->json([
            'data' => new DisbursementResource($disbursement),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($disbursement)
    {
        $disbursement = Disbursement::find($disbursement);

        if (! $disbursement) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }
        return response()->json([
            'data' => new DisbursementResource($disbursement),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $disbursement)
    {
        $validation = Validator::make($request->all(), [
            'budget_head_id' => 'required|integer',
            'chart_of_account_id' => 'required|integer',
            'payment_type' => 'required|string|in:member-payment,staff-payment,third-party,custom',
            'type' => 'required|string|in:loan,expense,salary,contribution,dividend,other',
            'beneficiary' => 'required|string|max:255',
            'description' => 'required',
            'amount' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $disbursement = Disbursement::find($disbursement);

        if (! $disbursement) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }

        $previousAmount = $disbursement->amount;

        $disbursement->update([
            'budget_head_id' => $request->budget_head_id,
            'chart_of_account_id' => $request->chart_of_account_id,
            'payment_type' => $request->payment_type,
            'type' => $request->type,
            'beneficiary' => $request->beneficiary,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        $fund = $disbursement->budgetHead->fund($this->getBudgetYear());

        if ($fund) {
            if ($previousAmount > $request->amount) {
                $diff = $previousAmount - $request->amount;

                $fund->booked_expenditure -= $diff;
                $fund->booked_balance += $diff;
            } else {
                $diff = $request->amount - $previousAmount;
                $fund->booked_expenditure += $diff;
                $fund->booked_balance -= $diff;
            }

            $fund->save();
        }

        return response()->json([
            'data' => new DisbursementResource($disbursement),
            'status' => 'success',
            'message' => 'Expenditure updated successfully!!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Disbursement $disbursement)
    {
        $disbursement = Disbursement::find($disbursement);

        if (! $disbursement) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }


        if ($disbursement->bundle_id > 0) {
            return response()->json([
                'data' => $disbursement,
                'status' => 'error',
                'message' => 'You cannot delete an expenditure that has been batched already!'
            ], 422);
        }

        $fund = $disbursement->budgetHead->fund($this->getBudgetYear());

        if ($fund) {
            $booked = $fund->booked_expenditure - $disbursement->amount;

            $fund->booked_expenditure -= $disbursement->amount;
            $fund->booked_balance = $fund->approved_amount - $booked;
            $fund->save();
        }

        $old = $disbursement;
        $disbursement->delete();

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    protected function getBudgetYear()
    {
        return config('settings.budget_year') ?? config('corp.budget.year');
    }
}
