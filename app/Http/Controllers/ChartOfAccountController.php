<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use App\Http\Resources\ChartOfAccountResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


/**
     * @OA\Post(
     * path="/chartofaccounts",
     *   tags={"Chart Of Accounts"},
     *   summary="Save ChartOfAccount",
     *   operationId="chartofaccounts",
     *
     *  @OA\Parameter(
     *      name="account_code_id",
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
     *           type="integer",
     *
     *
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
     * @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     *
     *
     *   @OA\Response(
     *      response=201,
     *       description="ChartOfAccount   has been created successfully!",
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
     *     path="/chartofaccounts",
     *     tags={"Chart Of Accounts"},
     *      summary="Returns all chartofaccounts on the system",
     *     description="Returns all chartofaccounts on the system",
     *     operationId="findChartOfAccounts",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ChartOfAccount")
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
     *     path="/chartofaccounts/{id}",
     *     tags={"Chart Of Accounts"},
     *     summary="Get Chart of account by id",
     *     description="Returns based on id ",
     *     operationId="showChartOfAccount",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Chart of account id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="ChartOfAccount for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ChartOfAccount")
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
     *     path="/chartofaccounts/{id}/edit",
     *     tags={"Chart Of Accounts"},
     *      summary="Open form to edit Chart of account",
     *     description="Returns based on id ",
     *     operationId="editChartOfAccount",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Chart of account id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ChartOfAccount")
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
     *          description="Invalid Chart of account id"
     *      )
     *
     * )
     *     )
     * )
     */

                /**
     * @OA\Put(
     *     path="/chartofaccounts/{id}",
     *     tags={"Chart Of Accounts"},
     *      summary="update Chart of account by database",
     *     description="Updates Chart of account in database",
     *     operationId="updateChartOfAccount",
     *
     *      *  @OA\Parameter(
     *      name="account_code_id",
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
     *           type="integer",
     *
     *
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
     * @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     *
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
     *         response=200,
     *         description="Success",
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
     *          description="Invalid Chart of account id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/chartofaccounts/{id}",
     *     tags={"Chart Of Accounts"},
     *      summary="remove Chart of account from database",
     *     description="Deletes Chart of account in database",
     *     operationId="updateChartOfAccount",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Chart of account id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="ChartOfAccount deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ChartOfAccount")
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
     *          description="Invalid Chart of account id"
     *      )
     *
     * )
     *     )
     * )
     */
class ChartOfAccountController extends Controller
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
        $chartOfAccounts = ChartOfAccount::latest()->get();

        if ($chartOfAccounts->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found!!'
            ], 200);
        }

        return response()->json([
            'data' => ChartOfAccountResource::collection($chartOfAccounts),
            'status' => 'success',
            'message' => 'Account Codes List'
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
            'account_code_id' => 'required|integer',
            'code' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $chartOfAccount = ChartOfAccount::create([
            'account_code_id' => $request->account_code_id,
            'name' => $request->name,
            'code' => $request->code,
            'label' => Str::slug($request->name)
        ]);

        return response()->json([
            'data' => new ChartOfAccountResource($chartOfAccount),
            'status' => 'success',
            'message' => 'New Chart of Account created!!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function show($chartOfAccount)
    {
        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        return response()->json([
            'data' => new ChartOfAccountResource($chartOfAccount),
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($chartOfAccount)
    {
        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        return response()->json([
            'data' => new ChartOfAccountResource($chartOfAccount),
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chartOfAccount)
    {
        $validator = Validator::make($request->all(), [
            'account_code_id' => 'required|integer',
            'code' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        $chartOfAccount->update([
            'account_code_id' => $request->account_code_id,
            'name' => $request->name,
            'code' => $request->code,
            'label' => Str::slug($request->name)
        ]);

        return response()->json([
            'data' => new ChartOfAccountResource($chartOfAccount),
            'status' => 'success',
            'message' => 'New Chart of Account updated!!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($chartOfAccount)
    {
        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        $old = $chartOfAccount;
        $chartOfAccount->delete();

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Chart of Account deleted successfully!!'
        ], 200);
    }
}
