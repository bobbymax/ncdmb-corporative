<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BudgetResource;
use Illuminate\Support\Str;
use Carbon\Carbon;


/**
     * @OA\Post(
     * path="/budgets",
     *   tags={"Budgets"},
     *   summary="Save  budget",
     *   operationId="budget",
     *
     *
     *   @OA\Parameter(
     *      name="budget_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     *  @OA\Parameter(
     *      name="category",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="interest",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="restriction",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="commitment",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="limit",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="double"
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Budget  has been created successfully!",
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
     *     path="/budgets",
     *     tags={"Budgets"},
     *      summary="Returns all budgets on the system",
     *     description="Returns all budgets on the system",
     *     operationId="findBudget",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Budget")
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
     *     path="/budgets/{id}",
     *     tags={"Budgets"},
     *     summary="Get budget by id",
     *     description="Returns based on id ",
     *     operationId="showBudget",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="budget id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Budget for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Budget")
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
     *     path="/budgets/{id}/edit",
     *     tags={"Budgets"},
     *      summary="Open form to edit budget",
     *     description="Returns  Budget based on id ",
     *     operationId="editBudget",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="budget id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Budget")
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
     *          description="Invalid budget id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/budgets/{id}",
     *     tags={"Budgets"},
     *      summary="update budget head by database",
     *     description="Updates budget head in database",
     *     operationId="updateBudget",
     *
     *
     *   @OA\Parameter(
     *      name="budget_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     *  @OA\Parameter(
     *      name="category",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="interest",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="restriction",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="commitment",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="limit",
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
     *          description="Invalid budget id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/budgets/{id}",
     *     tags={"Budget "},
     *      summary="remove budget from database",
     *     description="Deletes budget in database",
     *     operationId="updateBudget",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="budget id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Budget deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Budget")
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
     *          description="Invalid budget id"
     *      )
     *
     * )
     *     )
     * )
     */
class BudgetController extends Controller
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
        $budgets = Budget::all();
        if ($budgets->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }

        return response()->json([
            'data' => BudgetResource::collection($budgets),
            'status' => 'success',
            'message' => 'Budget list'
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
        $validation = Validator::make($request->all(), [
            'description' => 'required|unique:budgets',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 422);
        }

        $budget = Budget::create([
            'code' => 'BGT' . LoanUtilController::generateCode(),
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => new BudgetResource($budget),
            'status' => 'success',
            'message' => 'Budget has been created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($budget)
    {
        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => new BudgetResource($budget),
            'status' => 'success',
            'message' => 'Budget details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($budget)
    {
        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => new BudgetResource($budget),
            'status' => 'success',
            'message' => 'Budget details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $budget)
    {
        $validation = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $budget = Budget::where('code', $budget)->first();

        if (! $budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $budget->update([
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => new BudgetResource($budget),
            'status' => 'success',
            'message' => 'Budget has been updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($budget)
    {
        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $budget->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'This budget has been deleted successfully.'
        ], 200);
    }

    public function changeBudgetStatus(Request $request, $budget)
    {
        $validation = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $budget = Budget::where('code', $budget)->first();

        if (!$budget) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $status = $request->status;

        if ($status === true) {
            $budget->update([
                'active' => $status,
            ]);

            return response()->json([
                'data' => new BudgetResource($budget),
                'status' => 'success',
                'message' => 'Budget has been approved'
            ], 201);
        } elseif ($status === false) {
            $budget->update([
                'active' => $status,
            ]);

            return response()->json([
                'data' => new BudgetResource($budget),
                'status' => 'success',
                'message' => 'Budget has been disapproved'
            ], 201);
        }else{
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Invalid budget status'
            ], 201);
        }
    }
}
