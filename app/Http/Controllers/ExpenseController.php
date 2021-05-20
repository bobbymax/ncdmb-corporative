<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\Receive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
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
        $expenses = Expense::all();

        if ($expenses->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No dara found!!'
            ], 404);
        }

        return response()->json([
            'data' => ExpenseResource::collection($expenses),
            'status' => 'info',
            'message' => 'Expense list'
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
        $validator = Validator::make($request->all(), [
            'budget_head_id' => 'required|integer',
            'identifier' => 'required',
            'due_date' => 'required|date',
            'amount' => 'required|integer',
            'description' => 'required|min:3',
            'currency' => 'required|in:NGN,USD,GBP',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'No dara found!!'
            ], 500);
        }

        $receiver = Receive::where('identifier', $request->identifier)->first();

        if (! $receiver) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID'
            ], 422);
        }

        $expense = Expense::create([
            'budget_head_id' => $request->budget_head_id,
            'receive_id' => $receiver->id,
            'reference' => time(),
            'due_date' => Carbon::parse($request->due_date),
            'amount' => $request->amount,
            'currency' => $request->currency,
            'description' => $request->description
        ]);

        return response()->json([
            'data' => new ExpenseResource($expense),
            'status' => 'success',
            'message' => 'Expense has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($expense)
    {
        $expense = Expense::find($expense);

        if (! $expense) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID selected'
            ], 422);
        }

        return response()->json([
            'data' => new ExpenseResource($expense),
            'status' => 'success',
            'message' => 'Expense Details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($expense)
    {
        $expense = Expense::find($expense);

        if (! $expense) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID selected'
            ], 422);
        }

        return response()->json([
            'data' => new ExpenseResource($expense),
            'status' => 'success',
            'message' => 'Expense Details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $expense)
    {
        $validator = Validator::make($request->all(), [
            'budget_head_id' => 'required|integer',
            'identifier' => 'required',
            'due_date' => 'required|date',
            'amount' => 'required|integer',
            'description' => 'required|min:3',
            'currency' => 'required|in:NGN,USD,GBP',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'No dara found!!'
            ], 500);
        }

        $receiver = Receive::where('identifier', $request->identifier)->first();

        if (! $receiver) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID'
            ], 422);
        }

        $expense = Expense::find($expense);

        if (! $expense) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID selected'
            ], 422);
        }

        $expense->update([
            'budget_head_id' => $request->budget_head_id,
            'receive_id' => $receiver->id,
            'due_date' => Carbon::parse($request->due_date),
            'amount' => $request->amount,
            'currency' => $request->currency,
            'description' => $request->description
        ]);

        return response()->json([
            'data' => new ExpenseResource($expense),
            'status' => 'success',
            'message' => 'Expense has been created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($expense)
    {
        $expense = Expense::find($expense);

        if (! $expense) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID selected'
            ], 422);
        }

        $expense->delete();

        return response()->json([
            'data' => null,
            'status' => 'error',
            'message' => 'No dara found!!'
        ], 200);
    }
}
