<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
     * @OA\Post(
     * path="/specifications",
     *   tags={"Specifications"},
     *   summary="Save  specification",
     *   operationId="specifications",
     *
     *  @OA\Parameter(
     *      name="investment_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="double"
     *      )
     * ),
     * @OA\Parameter(
     *      name="slots",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          enum={"pending", "exhausted"}
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Specification   has been created successfully!",
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
     *     path="/specifications",
     *     tags={"Specifications"},
     *      summary="Returns all specifications on the system",
     *     description="Returns all specifications on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Specification")
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
     *     path="/specifications/{id}",
     *     tags={"Specifications"},
     *     summary="Get specification by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="specification id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Specification for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Specification")
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
     *     path="/specifications/{id}/edit",
     *     tags={"Specifications"},
     *      summary="Open form to edit specification",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="specification id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Specification")
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
     *          description="Invalid specification id"
     *      )
     *
     * )
     *     )
     * )
     */

                /**
     * @OA\Put(
     *     path="/specifications/{id}",
     *     tags={"Specifications"},
     *      summary="update specification by database",
     *     description="Updates specification in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *      name="investment_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="double"
     *      )
     * ),
     * @OA\Parameter(
     *      name="slots",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
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
     *          description="Invalid specification id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/specifications/{id}",
     *     tags={"Specifications"},
     *      summary="remove specification from database",
     *     description="Deletes specification in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="specification id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Specification deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Specification")
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
     *          description="Invalid specification id"
     *      )
     *
     * )
     *     )
     * )
     */
class SpecificationController extends Controller
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
        $specifications = Specification::all();
        if ($specifications->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $specifications,
            'status' => 'success',
            'message' => $specifications->count() . ' data were found!'
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
        $validation = Validator::make($request->all(), [
            'investment_id' => 'required|integer',
            'title' => 'required|string|max:255|unique:specifications',
            'description' => 'required|min:5',
            'amount' => 'required|integer',
            'slots' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $specification = Specification::create([
            'investment_id' => $request->investment_id,
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'description' => $request->description,
            'amount' => $request->amount,
            'slots' => $request->slots
        ]);

        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Specification created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function show($specification)
    {
        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function edit($specification)
    {
        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $specification)
    {
        $validation = Validator::make($request->all(), [
            'investment_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:specifications',
            'description' => 'required|min:5',
            'amount' => 'required|integer',
            'slots' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }

        $specification->update([
            'investment_id' => $request->investment_id,
            'title' => $request->title,
            'label' => $request->label,
            'description' => $request->description,
            'amount' => $request->amount,
            'slots' => $request->slots
        ]);

        return response()->json([
            'data' => $specification,
            'status' => 'success',
            'message' => 'Specification updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function destroy($specification)
    {
        $specification = Specification::where('label', $specification)->first();
        if (! $specification) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }
        $specification->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data deleted successfully!'
        ], 200);
    }
}
