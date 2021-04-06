<?php

namespace App\Http\Controllers;

use App\Models\BudgetHead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\BugetHeadResource;
use App\Helpers\BudgetHelperClass;
use Illuminate\Support\Facades\Validator;

class BudgetHeadController extends Controller
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
        $budgetHeads = BudgetHead::latest()->get();

        if ($budgetHeads->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found'
            ], 404);
        }

        return response()->json([
            'data' => BugetHeadResource::collection($budgetHeads),
            'status' => 'success',
            'message' => $budgetHeads->count() . ' data found!'
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
        $validator = Validator::make($request->all(), [
            'budget_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|min:3',
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 505);
        }

        $status = (new BudgetHelperClass($request->budget_id, $request->amount))->init();

        if ($status === "not found") {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Budget not found!!'
            ], 422);
        }

        if ($status === "amount not valid") {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The BudgetHead amount sum cannot be higher than the Budget amount!!'
            ], 422);
        }

        $budgetHead = BudgetHead::create([
            'budget_id' => $request->budget_id,
            'code' => "BHD" . time(),
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        // Alert new activity before sending response

        return response()->json([
            'data' => new BugetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\Response
     */
    public function show($budgetHead)
    {
        $budgetHead = BudgetHead::find($budgetHead);

        if (! $budgetHead) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This budget head ID is invalid'
            ], 422);
        }

        return response()->json([
            'data' => new BugetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\Response
     */
    public function edit($budgetHead)
    {
        $budgetHead = BudgetHead::find($budgetHead);

        if (! $budgetHead) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This budget head ID is invalid'
            ], 422);
        }

        return response()->json([
            'data' => new BugetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $budgetHead)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 505);
        }

        $budgetHead = BudgetHead::find($budgetHead);

        if (! $budgetHead) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This budget head ID is invalid'
            ], 422);
        }

        $budgetHead->update([
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        // Alert new activity before sending response

        return response()->json([
            'data' => new BugetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head created successfully!'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\Response
     */
    public function destroy($budgetHead)
    {
        $budgetHead = BudgetHead::find($budgetHead);

        if (! $budgetHead) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This budget head ID is invalid'
            ], 422);
        }

        $budgetHead->delete();

        // Alert new activity before sending response

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Budget head has been deleted successfully!'
        ], 200);
    }
}
