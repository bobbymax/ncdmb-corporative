<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use App\Models\Loan;
use App\Http\Resources\GuarantorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
     * @OA\Post(
     * path="/guarantors",
     *   tags={"Guarantors"},
     *   summary="Save  guarantor",
     *   operationId="guarantors",
     *
     *
     *   @OA\Parameter(
     *      name="loan_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="remark",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Guarantor for Budget Head has been created successfully!",
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
     *     path="/guarantors",
     *     tags={"Guarantors"},
     *      summary="Returns all guarantors on the system",
     *     description="Returns all guarantors on the system",
     *     operationId="findGuarantors",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Guarantor")
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
     *     path="/guarantors/{id}",
     *     tags={"Guarantors"},
     *     summary="Get guarantor by id",
     *     description="Returns based on id ",
     *     operationId="showGuarantor",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="guarantor id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Guarantor for Budget Head details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Guarantor")
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
     *     path="/guarantors/{id}/edit",
     *     tags={"Guarantors"},
     *      summary="Open form to edit guarantor",
     *     description="Returns based on id ",
     *     operationId="editGuarantor",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="guarantor id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Guarantor")
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
     *          description="Invalid guarantor id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/guarantors/{id}",
     *     tags={"Guarantors"},
     *      summary="update guarantor by database",
     *     description="Updates guarantor in database",
     *     operationId="updateGuarantor",
     *
     *   @OA\Parameter(
     *      name="remark",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
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
     *          description="Invalid guarantor id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/guarantors/{id}",
     *     tags={"Guarantors"},
     *      summary="remove guarantor from database",
     *     description="Deletes guarantor in database",
     *     operationId="updateGuarantor",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="guarantor id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Guarantor deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Guarantor")
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
     *          description="Invalid guarantor id"
     *      )
     *
     * )
     *     )
     * )
     */
class GuarantorController extends Controller
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
        $guarantors = Guarantor::all();
        if ($guarantors->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data was found'
            ], 200);
        }
        return response()->json([
            'data' => GuarantorResource::collection($guarantors),
            'status' => 'success',
            'message' => 'Data was found'
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function show($guarantor)
    {
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found'
            ], 404);
        }
        return response()->json([
            'data' => new GuarantorResource($guarantor),
            'status' => 'success',
            'message' => 'Data was found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function edit(Guarantor $guarantor)
    {
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found'
            ], 404);
        }
        return response()->json([
            'data' => new GuarantorResource($guarantor),
            'status' => 'success',
            'message' => 'Data was found'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $guarantor)
    {
        $validation = Validator::make($request->all(), [
            'remark' => 'required|min:3',
            'status' => 'required|string|max:255'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Fix the following errors'
            ], 500);
        }
        $guarantor = Guarantor::find($guarantor);
        $loan = Loan::find($guarantor->loan_id);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found'
            ], 404);
        }
        $guarantor->update([
            'remark' => $request->remark,
            'status' => $request->status
        ]);

        if ($loan) {
            $list = $loan->sponsors->where('status', 'approved')->count();

            // treasury

            if ($list == 3) {
                $loan->status = "registered";
                $loan->stage = "secretariate";
                $loan->save();
            }
        }


        return response()->json([
            'data' => new GuarantorResource($guarantor),
            'status' => 'success',
            'message' => 'Loan record updated successfully!!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function destroy($guarantor)
    {
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found'
            ], 404);
        }
        $old = $guarantor;
        $guarantor->delete();
        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Data was deleted successfully!'
        ], 200);
    }
}
