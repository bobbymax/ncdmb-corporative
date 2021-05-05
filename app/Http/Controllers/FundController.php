<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FundController extends Controller
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
        $funds = Fund::all();

        if ($funds->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found'
            ], 404);
        }

        return response()->json([
            'data' => $funds,
            'status' => 'success',
            'message' => 'No data found!'
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
            'approved_amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 500);
        }

        $fund = Fund::create([
            'budget_head_id' => $request->budget_head_id,
            'description' => $request->description,
            'approved_amount' => $request->approved_amount
        ]);

        return response()->json([
            'data' => $fund,
            'status' => 'success',
            'message' => 'Fund for Budget Head has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($fund)
    {
        $fund = Fund::find($fund);

        if (! $fund) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This ID is invalid'
            ], 422);
        }

        return response()->json([
            'data' => $fund,
            'status' => 'success',
            'message' => 'Fund for Budget Head details!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($fund)
    {
        $fund = Fund::find($fund);

        if (! $fund) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This ID is invalid'
            ], 422);
        }

        return response()->json([
            'data' => $fund,
            'status' => 'success',
            'message' => 'Fund for Budget Head details!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $fund)
    {
        $validator = Validator::make($request->all(), [
            'budget_head_id' => 'required|integer',
            'approved_amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 500);
        }

        $fund = Fund::find($fund);

        if (! $fund) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This ID is invalid'
            ], 422);
        }

        $fund->update([
            'budget_head_id' => $request->budget_head_id,
            'description' => $request->description,
            'approved_amount' => $request->approved_amount
        ]);

        return response()->json([
            'data' => $fund,
            'status' => 'success',
            'message' => 'Fund for Budget Head has been created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($fund)
    {
        $fund = Fund::find($fund);

        if (! $fund) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This ID is invalid'
            ], 422);
        }

        $fund->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Fund for Budget Head details!'
        ], 200);
    }
}
