<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BatchEntry;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
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
        $batches = Batch::all();

        if ($batches->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ],204);
        }

        return response()->json([
            'data' => $batches,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batchables' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the follow errors'
            ],500);
        }

        $batch = new Batch;
        $batch->code = time();

        if ($batch->save() && $request->has('batchables')) {
            foreach ($request->batchables as $entry) {
                $expense = Expense::find($entry);
                $batchEntry = new BatchEntry;
                $batchEntry->batch_id = $batch->id;
                // $batchEntry->batchable()->save($entry);
                $expense->batchEntries()->save($batchEntry);
            }
        }

        return response()->json([
            'data' => $batch,
            'status' => 'success',
            'message' => 'Batch has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($batch)
    {
        $batch = Batch::where('code', $batch)->first();

        if (! $batch) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Batch not found'
            ], 422);
        }

        return response()->json([
            'data' => $batch,
            'status' => 'success',
            'message' => 'Batch Details!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($batch)
    {
        $batch = Batch::where('code', $batch)->first();

        if (! $batch) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Batch not found'
            ], 422);
        }

        return response()->json([
            'data' => $batch,
            'status' => 'success',
            'message' => 'Batch Details!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        //
    }
}
