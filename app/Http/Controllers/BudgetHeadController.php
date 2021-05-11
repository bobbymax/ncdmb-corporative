<?php

namespace App\Http\Controllers;

use App\Http\Resources\BudgetHeadResource;
use App\Models\BudgetHead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
     * @return \Illuminate\Http\JsonResponse
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
            'data' => BudgetHeadResource::collection($budgetHeads),
            'status' => 'success',
            'message' => $budgetHeads->count() . ' data found!'
        ], 200);
    }

    public function loaners()
    {
        $budgetHeads = BudgetHead::where('category', 'loan')->get();

        if ($budgetHeads->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found'
            ], 404);
        }

        return response()->json([
            'data' => BudgetHeadResource::collection($budgetHeads),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'budget_id' => 'required|integer',
            'description' => 'required|min:3|unique:budget_heads',
            'category' => 'required|string|max:255',
            'type' => 'required|in:capital,recursive,personnel'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 500);
        }

        $budgetHead = BudgetHead::create([
            'budget_id' => $request->budget_id,
            'code' => "BHD" . time(),
            'description' => $request->description,
            'category' => $request->category,
            'interest' => $request->interest,
            'restriction' => $request->restriction,
            'commitment' => $request->commitment,
            'limit' => $request->limit,
            'payable' => $request->payable,
            'frequency' => $request->frequency,
            'type' => $request->type
        ]);

        // Alert new activity before sending response

        return response()->json([
            'data' => new BudgetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\JsonResponse
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
            'data' => new BudgetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\JsonResponse
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
            'data' => new BudgetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $budgetHead)
    {
        $validator = Validator::make($request->all(), [
            'budget_id' => 'required|integer',
            'description' => 'required|min:3',
            'category' => 'required|string|max:255',
            'type' => 'required|in:capital,recursive,personnel'
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
            'description' => $request->description,
            'category' => $request->category,
            'interest' => $request->interest,
            'restriction' => $request->restriction,
            'commitment' => $request->commitment,
            'limit' => $request->limit,
            'payable' => $request->payable,
            'frequency' => $request->frequency,
            'type' => $request->type
        ]);

        // Alert new activity before sending response

        return response()->json([
            'data' => new BudgetHeadResource($budgetHead),
            'status' => 'success',
            'message' => 'Budget head created successfully!'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetHead  $budgetHead
     * @return \Illuminate\Http\JsonResponse
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
