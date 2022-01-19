<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\Receive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
     * @OA\Post(
     * path="/expenses",
     *   tags={"Expenses"},
     *   summary="Save  expense",
     *   operationId="expenses",
     *
     *
     *   @OA\Parameter(
     *      name="range",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="isActive",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="AccountCode   has been created successfully!",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
        * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     *
     * )
     * )
    */
      /**
     * @OA\Get(
     *     path="/expenses",
     *     tags={"Expenses"},
     *      summary="Returns all expenses on the system",
     *     description="Returns all expenses on the system",
     *     operationId="findExpenses",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AccountCode")
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
       * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     * )
     *     )
     * )
     */

           /**
     * @OA\Get(
     *     path="/expenses/{id}",
     *     tags={"Expenses"},
     *     summary="Get expense by id",
     *     description="Returns based on id ",
     *     operationId="showExpense",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="expense id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="AccountCode for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AccountCode")
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     *      @OA\Response(
     *          response=422,
     *          description="This ID is invalid"
     *      )
     *
     * )
     *     )
     * )
     */

                /**
     * @OA\Get(
     *     path="/expenses/{id}/edit",
     *     tags={"Expenses"},
     *      summary="Open form to edit expense",
     *     description="Returns based on id ",
     *     operationId="editExpense",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="expense id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AccountCode")
     *         )
     *
     *     ),
     *     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid expense id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/expenses/{id}",
     *     tags={"Expenses"},
     *      summary="update expense by database",
     *     description="Updates expense in database",
     *     operationId="updateExpense",
     *
     *    @OA\Parameter(
     *      name="budget_head_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="approved_amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="double"
     *      )
     * ),
     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid expense id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/expenses/{id}",
     *     tags={"Expenses"},
     *      summary="remove expense from database",
     *     description="Deletes expense in database",
     *     operationId="updateExpense",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="expense id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="AccountCode deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AccountCode")
     *         )
     *
     *     ),
     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid expense id"
     *      )
     *
     * )
     *     )
     * )
     */
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
