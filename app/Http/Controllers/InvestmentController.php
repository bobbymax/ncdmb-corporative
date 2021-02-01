<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvestmentController extends Controller
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
        $investments = Investment::latest()->get();
        if ($investments->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $investments,
            'status' => 'success',
            'message' => 'Data found successfully!'
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
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:investments',
            'date_acquired' => 'required|date',
            'amount' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the follwoing errors!'
            ], 500);
        }

        $investment = Investment::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'label' => $request->label,
            'date_acquired' => Carbon::parse($request->date_acquired),
            'expiry_date' => Carbon::parse($request->expiry_date),
            'amount' => $request->amount,
            'description' => $request->description,
            'allocations' => $request->allocations
        ]);

        return response()->json([
            'data' => $investment,
            'status' => 'success',
            'message' => 'Investment created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show($investment)
    {
        $investment = Investment::where('label', $investment)->first();
        if (! $investment) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        }
        return response()->json([
            'data' => $investment,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit($investment)
    {
        $investment = Investment::where('label', $investment)->first();
        if (! $investment) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        }
        return response()->json([
            'data' => $investment,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $investment)
    {
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:investments',
            'date_acquired' => 'required|date',
            'amount' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the follwoing errors!'
            ], 500);
        }

        $investment = Investment::where('label', $investment)->first();
        if (! $investment) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        }

        $investment->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'label' => $request->label,
            'date_acquired' => Carbon::parse($request->date_acquired),
            'expiry_date' => Carbon::parse($request->expiry_date),
            'amount' => $request->amount,
            'description' => $request->description,
            'allocations' => $request->allocations
        ]);

        return response()->json([
            'data' => $investment,
            'status' => 'success',
            'message' => 'Investment updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy($investment)
    {
        $investment = Investment::where('label', $investment)->first();
        if (! $investment) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        }
        $investment->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Investment details deleted successfully!'
        ], 200);
    }
}
