<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Helpers\LoanCalculator;
use App\Helpers\BudgetChecker;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ExpenditureResource;

class ExpenditureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenditures = Expenditure::all();

        if ($counter = $expenditures->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found'
            ], 404);
        }

        return response()->json([
            'data' => ExpenditureResource::collection($expenditures),
            'status' => 'success',
            'message' => $expenditures->count() . ' data found!'
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

    public function budgetChecker(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 505);
        }

        $category = Category::find($request->category);

        if (! $category) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This input was invalid'
            ], 422);
        }

        $results = (new BudgetChecker($category, $request->amount))->init();

        return response()->json([
            'data' => $results,
            'status' => 'success',
            'message' => 'Data collection!'
        ], 200);
    }

    public function loanCalculator(Request $request, $loan)
    {
        $loan = Loan::where('code', $loan)->first();

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This input was invalid'
            ], 404);
        }

        $values = (new LoanCalculator($loan, $request->all()))->init();

        return response()->json([
            'data' => $values,
            'status' => 'success',
            'message' => 'Schedule done successfully!'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'budget_id' => 'required|integer',
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'label' => 'unique:expenditures',
            'code' => 'unique:expenditures',
            'amount' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $budget = Budget::find($request->budget_id);

        if (! $budget) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'The budget code is invalid'
            ], 500);
        }

        if (! ($budget->expenditures->sum('amount') < $budget->amount)) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'You cannot exceed the approved budget amount allocated!'
            ], 403);
        }

        $expenditure = Expenditure::create([
            'code' => LoanUtilController::generateLoanCode(),
            'budget_id' => $budget->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'label' => LoanUtilController::slugify($request->title),
            'amount' => $request->amount,
            'balance' => $request->amount
        ]);

        return response()->json([
            'data' => new ExpenditureResource($expenditure),
            'status' => 'success',
            'message' => 'This expenditure has been created successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show($expenditure)
    {
        $expenditure = Expenditure::where('code', $expenditure)->first();

        if (! $expenditure) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Expenditure data not found'
            ], 404);
        }

        return response()->json([
            'data' => new ExpenditureResource($expenditure),
            'status' => 'success',
            'message' => 'Expenditure data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function edit($expenditure)
    {
        $expenditure = Expenditure::where('code', $expenditure)->first();

        if (! $expenditure) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Expenditure data not found'
            ], 404);
        }

        return response()->json([
            'data' => new ExpenditureResource($expenditure),
            'status' => 'success',
            'message' => 'Expenditure data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $expenditure)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $expenditure = Expenditure::where('code', $expenditure)->first();

        if (! $expenditure) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'Expenditure data not found'
            ], 500);
        }

        $expenditure->update([
            'title' => $request->title,
            'label' => $request->label,
        ]);

        return response()->json([
            'data' => new ExpenditureResource($expenditure),
            'status' => 'success',
            'message' => 'This expenditure has been created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy($expenditure)
    {
        $expenditure = Expenditure::where('code', $expenditure)->first();

        if (! $expenditure) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Expenditure data not found'
            ], 404);
        }

        $expenditure->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Expenditure data deleted successfully!'
        ], 200);
    }
}
