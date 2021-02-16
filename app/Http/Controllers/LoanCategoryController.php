<?php

namespace App\Http\Controllers;

use App\Models\LoanCategory;
use App\Models\BudgetHead;
use Illuminate\Http\Request;
use App\Http\Resources\LoanCategoryResource;
use Illuminate\Support\Str;

class LoanCategoryController extends Controller
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
        $loanCategories = LoanCategory::latest()->get();

        if ($loanCategories->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => LoanCategoryResource::collection($loanCategories),
            'status' => 'success',
            'message' => 'List of loan categories'
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'budget_head_id' => 'required|integer',
            'name' => 'required|string|max:255|unique:loan_categories',
            'restriction' => 'required|integer',
            'interest' => 'required|integer',
            'frequency' => 'required|string',
            'limit' => 'required|integer',
            'amount' => 'required|integer',
            'description' => 'required|min:5',
            'payable' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $budgetHead = BudgetHead::find($request->budget_head_id);

        if ($budgetHead->count() != 1) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid budget head'
            ], 500);
        }

        $balance = $budgetHead->amount - $budgetHead->loanCategories()->sum('amount');

        if ($request->amount > $balance) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The amount entered exceeds that approved amount for this Budget Head'
            ], 422);
        }

        $loanCategory = LoanCategory::create([
            'budget_head_id' => $budgetHead->id,
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'description' => $request->description,
            'interest' => $request->interest,
            'frequency' => $request->frequency,
            'restriction' => $request->restriction,
            'amount' => $request->amount,
            'limit' => $request->limit,
            'payable' => $request->payable,
            'committment' => $request->committment
        ]);

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Oops!!! Something went terribly wrong!'
            ], 500);
        }

        return response()->json([
            'data' => new LoanCategoryResource($loanCategory),
            'status' => 'success',
            'message' => 'Loan Category has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanCategory  $loanCategory
     * @return \Illuminate\Http\Response
     */
    public function show($loanCategory)
    {
        $loanCategory = LoanCategory::where('label', $loanCategory)->first();

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This loan category is invalid!'
            ], 422);
        }

        return response()->json([
            'data' => new LoanCategoryResource($loanCategory),
            'status' => 'success',
            'message' => 'Loan Category details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanCategory  $loanCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($loanCategory)
    {
        $loanCategory = LoanCategory::where('label', $loanCategory)->first();

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This loan category is invalid!'
            ], 422);
        }

        return response()->json([
            'data' => new LoanCategoryResource($loanCategory),
            'status' => 'success',
            'message' => 'Loan Category details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanCategory  $loanCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $loanCategory)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'restriction' => 'required|integer',
            'interest' => 'required|integer',
            'frequency' => 'required|string',
            'limit' => 'required|integer',
            'description' => 'required|min:5',
            'payable' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $loanCategory = LoanCategory::where('label', $loanCategory)->first();

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This loan category is invalid!'
            ], 422);
        }

        $loanCategory->update([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'description' => $request->description,
            'interest' => $request->interest,
            'frequency' => $request->frequency,
            'restriction' => $request->restriction,
            'limit' => $request->limit,
            'payable' => $request->payable,
            'committment' => $request->committment
        ]);

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Oops!!! Something went terribly wrong!'
            ], 500);
        }

        return response()->json([
            'data' => new LoanCategoryResource($loanCategory),
            'status' => 'success',
            'message' => 'Loan Category has been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanCategory  $loanCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($loanCategory)
    {
        $loanCategory = LoanCategory::where('label', $loanCategory)->first();

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This loan category is invalid!'
            ], 422);
        }

        $loanCategory->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Loan Category deleted successfully!'
        ], 200);
    }
}
