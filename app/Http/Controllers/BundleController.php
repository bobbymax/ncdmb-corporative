<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Disbursement;
use App\Http\Resources\BundleResource;

class BundleController extends Controller
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
        $batches = Bundle::all();

        if ($batches->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found'
            ], 200);
        }

        return response()->json([
            'data' => BundleResource::collection($batches),
            'status' => 'success',
            'message' => 'Batch List'
        ],200);
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
        $validator = Validator::make($request->all(), [
            'batch_no' => 'required|string',
            'expenditures' => 'required|array',
            'noOfClaim' => 'required|integer',
            'amount' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the follow errors'
            ],500);
        }

        $batch = Bundle::create([
            'user_id' => auth()->user()->id,
            'batch_no' => $request->batch_no,
            'amount' => $request->amount,
            'noOfClaim' => $request->noOfClaim,
        ]);

        if ($batch) {
            foreach ($request->expenditures as $value) {
                $expenditure = Disbursement::find($value['id']);

                if ($expenditure) {
                    $expenditure->bundle_id = $batch->id;
                    $expenditure->status = "batched";
                    $expenditure->save();

                    if ($expenditure->loan_id > 0) {
                        $expenditure->loan->status = "disbursed";
                        $expenditure->loan->save();
                    }
                }
            }
        }

        return response()->json([
            'data' => new BundleResource($batch),
            'status' => 'success',
            'message' => 'Batch created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show($bundle)
    {
        $bundle = Bundle::find($bundle);

        if (! $bundle) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID selected'
            ], 422);
        }

        return response()->json([
            'data' => new BundleResource($bundle),
            'status' => 'success',
            'message' => 'Batch details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function edit($bundle)
    {
        $bundle = Bundle::find($bundle);

        if (! $bundle) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID selected'
            ], 422);
        }

        return response()->json([
            'data' => new BundleResource($bundle),
            'status' => 'success',
            'message' => 'Batch details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundle $bundle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundle $bundle)
    {
        //
    }
}
