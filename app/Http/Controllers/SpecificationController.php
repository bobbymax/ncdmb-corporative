<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specifications = Specification::all();
        if ($specifications->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $specifications,
            'status' => 'success',
            'message' => $specifications->count() . ' data were found!'
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
            'investment_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:specifications',
            'description' => 'required|min:5',
            'amount' => 'required|integer',
            'slots' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $specification = Specification::create([
            'investment_id' => $request->investment_id,
            'title' => $request->title,
            'label' => $request->label,
            'description' => $request->description,
            'amount' => $request->amount,
            'slots' => $request->slots
        ]);

        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Specification created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function show($specification)
    {
        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function edit($specification)
    {
        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $specification)
    {
        $validation = Validator::make($request->all(), [
            'investment_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:specifications',
            'description' => 'required|min:5',
            'amount' => 'required|integer',
            'slots' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 404);
        }

        $specification->update([
            'investment_id' => $request->investment_id,
            'title' => $request->title,
            'label' => $request->label,
            'description' => $request->description,
            'amount' => $request->amount,
            'slots' => $request->slots
        ]);

        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Specification updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function destroy($specification)
    {
        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 404);
        }
        $specification->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data deleted successfully!'
        ], 200);
    }
}
