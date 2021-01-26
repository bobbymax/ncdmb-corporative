<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $budgets = Budget::all()->sortByDesc("created_at");
        if ($budgets->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }

        return response()->json([
            'data' => $budgets,
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
            'title' => 'required|string|max:255',
            'label' => 'unique:budgets',
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

        $existing = Budget::where('status', 'closed')->where('active', 1)->first();

        if ($existing) {
            return response()->json([
                'data' => null,
                'status' => 'warning',
                'message' => 'You are not permitted to create another budget until the previous budget has been marked as closed!'
            ], 403);
        }

        $budget = Budget::create([
            'code' => LoanUtilController::generateLoanCode(),
            'title' => $request->title,
            'label' => LoanUtilController::slugify($request->title),
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
                'status' => 'danger',
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
                'status' => 'danger',
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
            'code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255',
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
                'status' => 'danger',
                'message' => 'No data found'
            ], 404);
        }

        $budget->update([
            'code' => $request->code,
            'title' => $request->title,
            'label' => $request->label,
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
                'status' => 'danger',
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
}
