<?php

namespace App\Http\Controllers;

use App\Models\AccountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
     * @OA\Get(
     *     path="/accountCodes",
     *     tags={"AccountCodes"},
     *      summary="Returns all accountCodes on the system",
     *     description="Returns all accountCodes on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="AccountCodes List",
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
class AccountCodeController extends Controller
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
        $accountCodes = AccountCode::all();

        if ($accountCodes->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found!!'
            ], 404);
        }

        return response()->json([
            'data' => $accountCodes,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'range' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $accountCode = AccountCode::create([
            'name' => $request->name,
            'range' => $request->range,
            'label' => Str::slug($request->name)
        ]);

        return response()->json([
            'data' => $accountCode,
            'status' => 'success',
            'message' => 'New Account Code created!!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountCode  $accountCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($accountCode)
    {
        $accountCode = AccountCode::find($accountCode);

        if (! $accountCode) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        return response()->json([
            'data' => $accountCode,
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountCode  $accountCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($accountCode)
    {
        $accountCode = AccountCode::find($accountCode);

        if (! $accountCode) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        return response()->json([
            'data' => $accountCode,
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountCode  $accountCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $accountCode)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'range' => 'required'
        ]);

        $accountCode = AccountCode::find($accountCode);

        if (! $accountCode) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        $accountCode->update([
            'name' => $request->name,
            'range' => $request->range,
            'label' => Str::slug($request->name)
        ]);

        return response()->json([
            'data' => $accountCode,
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountCode  $accountCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($accountCode)
    {
        $accountCode = AccountCode::find($accountCode);

        if (! $accountCode) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        $accountCode->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Account Code deleted successfully!'
        ], 200);
    }
}
