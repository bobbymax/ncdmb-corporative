<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BudgetResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BudgetController extends Controller
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
        $budgets = Budget::all();
        if ($budgets->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }

        return response()->json([
            'data' => BudgetResource::collection($budgets),
            'status' => 'success',
            'message' => 'Budget list'
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
            'code' => 'unique:budgets',
            'title' => 'required|string|max:255|unique:budgets',
            'label' => 'unique:budgets',
            'amount' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
            'period' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $existing = Budget::where('active', 1);

        if ($existing->count() >= 1) {
            return response()->json([
                'data' => $existing,
                'status' => 'warning',
                'message' => 'You are not permitted to create another budget until the previous budget has been marked as closed!'
            ], 403);
        }

        $budget = Budget::create([
            'code' => 'bg' . LoanUtilController::generateCode(),
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'amount' => $request->amount,
            'description' => $request->description,
            'start' => Carbon::parse($request->start),
            'end' => Carbon::parse($request->end),
            'period' => $request->period,
            'status' => 'pending',
        ]);

        return response()->json([
            'data' => new BudgetResource($budget),
            'status' => 'success',
            'message' => 'Budget has been created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show($budget)
    {
        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => $budget,
            'status' => 'success',
            'message' => 'Budget details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit($budget)
    {
        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => $budget,
            'status' => 'success',
            'message' => 'Budget details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $budget)
    {
        $validation = Validator::make($request->all(), [
            // 'code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            // 'label' => 'required|string|max:255',
            'amount' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
            'period' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $budget->update([
            // 'code' => 'bg' . LoanUtilController::generateCode(),
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'amount' => $request->amount,
            'description' => $request->description,
            'start' => Carbon::parse($request->start),
            'end' => Carbon::parse($request->end),
            'period' => $request->period,
        ]);

        return response()->json([
            'data' => $budget,
            'status' => 'success',
            'message' => 'Budget has been created successfully.'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy($budget)
    {
        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $budget->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'This budget has been deleted successfully.'
        ], 200);
    }

    public function changeBudgetStatus(Request $request, $budget)
    {
        $validation = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $status = $request->status;

        if ($status === true) {
            $budget->update([
                'active' => $status,
            ]);

            return response()->json([
                'data' => new BudgetResource($budget),
                'status' => 'success',
                'message' => 'Budget has been approved'
            ], 201);
        } elseif ($status === false) {
            $budget->update([
                'active' => $status,
            ]);

            return response()->json([
                'data' => new BudgetResource($budget),
                'status' => 'success',
                'message' => 'Budget has been disapproved'
            ], 201);
        }else{
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Invalid budget status'
            ], 201);
        }
    }
}
