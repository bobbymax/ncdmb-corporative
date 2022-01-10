<?php

namespace App\Http\Controllers;

use App\Http\Resources\BudgetHeadResource;
use App\Models\BudgetHead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\BudgetHelperClass;
use Illuminate\Support\Facades\Validator;


/**
     * @OA\Post(
     * path="/budgetheads",
     *   tags={"Budget Heads"},
     *   summary="Save  budgethead",
     *   operationId="budgetHeads",
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
     *      name="commitmentt",
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
     *       description="Budget Head has been created successfully!",
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
     *     path="/budgetheads",
     *     tags={"Budget Heads"},
     *      summary="Returns all budget heads on the system",
     *     description="Returns all budget heads on the system",
     *     operationId="findBudgetHead",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BudgetHead")
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
     *     path="/budgetheads/{id}",
     *     tags={"Budget Heads"},
     *     summary="Get budget head by id",
     *     description="Returns based on id ",
     *     operationId="showBudgetHead",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="budget id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="BudgetHead for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BudgetHead")
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
     *     path="/budgetheads/{id}/edit",
     *     tags={"Budget Heads"},
     *      summary="Open form to edit budget head",
     *     description="Returns  Budget Head based on id ",
     *     operationId="editBudgetHead",
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
     *             @OA\Items(ref="#/components/schemas/BudgetHead")
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
     *     path="/budgetheads/{id}",
     *     tags={"Budget Heads"},
     *      summary="update budget head by database",
     *     description="Updates budget head in database",
     *     operationId="updateBudgetHead",
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
     *      name="commitmentt",
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
     *     path="/budgetheads/{id}",
     *     tags={"Budget Heads"},
     *      summary="remove budget from database",
     *     description="Deletes budget in database",
     *     operationId="updateBudgetHead",
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
     *         description="BudgetHead deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BudgetHead")
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
            'interest' => isset($request->interest) ? $request->interest : 0,
            'restriction' => isset($request->restriction) ? $request->restriction : 0,
            'commitment' => isset($request->commitment) ? $request->commitment : 0,
            'limit' => isset($request->limit) ? $request->limit : 0,
            'payable' => isset($request->payable) ? $request->payable : "na",
            'frequency' => isset($request->frequency) ? $request->frequency : "na",
            'type' => $request->type,
            'year' => date('Y')
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
