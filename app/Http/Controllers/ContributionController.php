<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contributions = Contribution::all();
        if ($contributions->count() < 1) {
            return response()->json([
                'data' => null, 
                'status' => 'success', 
                'message' => 'No data found!'
            ], 200);
        }
        return response()->json([
            'data' => $contributions, 
            'status' => 'success', 
            'message' => 'List of contributions'
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function show($contribution)
    {
        $contribution = Contribution::find($contribution);
        if (! $contribution) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This contribution does not exist'
            ], 404);
        }

        return response()->json([
            'data' => $contribution,
            'status' => 'success',
            'message' => 'Contribution found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function edit($contribution)
    {
        $contribution = Contribution::find($contribution);
        if (! $contribution) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This contribution does not exist'
            ], 404);
        }

        return response()->json([
            'data' => $contribution,
            'status' => 'success',
            'message' => 'Contribution found'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contribution)
    {
        $validation = Validation::make($request->all(), [
            'fee' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'Please fix this errors before proceeding!'
            ], 500);
        }

        $contribution = Contribution::find($contribution);
        if (! $contribution) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This contribution does not exist'
            ], 404);
        }

        $contribution->update([
            'fee' => $request->fee,
        ]);

        return response()->json([
            'data' => $contribution,
            'status' => 'success',
            'message' => 'Contribution updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contribution $contribution)
    {
        //
    }
}
