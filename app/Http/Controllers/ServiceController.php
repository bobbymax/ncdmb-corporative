<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
     * @OA\Post(
     * path="/services",
     *   tags={"Services"},
     *   summary="Save  service",
     *   operationId="services",
     *
     *
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="serviceCode",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="category",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="request_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="date"
     *      )
     * ),
     * @OA\Parameter(
     *      name="payment_method",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="closed",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Permission   has been created successfully!",
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
     *     path="/services",
     *     tags={"Services"},
     *      summary="Returns all services on the system",
     *     description="Returns all services on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *     path="/services/{id}",
     *     tags={"Services"},
     *     summary="Get service by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="service id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permission for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *     path="/services/{id}/edit",
     *     tags={"Services"},
     *      summary="Open form to edit service",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="service id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *          description="Invalid service id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/services/{id}",
     *     tags={"Services"},
     *      summary="update service by database",
     *     description="Updates service in database",
     *     operationId="updateRole",
     *
     *
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="serviceCode",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="category",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="request_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="date"
     *      )
     * ),
     * @OA\Parameter(
     *      name="payment_method",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="closed",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
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
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid service id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/services/{id}",
     *     tags={"Services"},
     *      summary="remove service from database",
     *     description="Deletes service in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="service id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permission deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *          description="Invalid service id"
     *      )
     *
     * )
     *     )
     * )
     */
class ServiceController extends Controller
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
        $services = Service::latest()->get();

        if ($services->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found!'
            ], 200);
        }
        return response()->json([
            'data' => ServiceResource::collection($services),
            'status' => 'success',
            'message' => $services->count() . ' data found!'
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
            'service_category_id' => 'required|integer',
            'code' => 'required|string|max:255|unique:services',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $service = Service::create([
            'user_id' => auth()->user()->id,
            'service_category_id' => $request->service_category_id,
            'code' => $request->code,
        ]);

        if ($service) {
            $field = ServiceField::create([
                'service_id' => $service->id,
                'loan_id' => $request->loan_id,
                'takeOff' => $request->takeOff ?? "undefined",
                'destination' => $request->destination ?? "undefined",
                'from' => $request->from,
                'to' => $request->to,
                'airline' => $request->airline,
                'type' => $request->type ?? "other",
                'trip' => $request->trip ?? "other",
                'liquidate' => $request->liquidate ?? "other",
                'timeOfDay' => $request->timeOfDay ?? "other",
                'amount' => $request->amount,
                'month' => $request->month,
                'passengers' => json_encode($request->passengers)
            ]);
        }

        return response()->json([
            'data' => new ServiceResource($service),
            'status' => 'success',
            'message' => 'Service request created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($service)
    {
        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        return response()->json([
            'data' => new ServiceResource($service),
            'status' => 'success',
            'message' => 'Data entry found!'
        ], 200);
    }

    public function fetchByCode($service)
    {
        $service = Service::where('code', $service)->first();

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        return response()->json([
            'data' => new ServiceResource($service),
            'status' => 'success',
            'message' => 'Data entry found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($service)
    {
        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        return response()->json([
            'data' => new ServiceResource($service),
            'status' => 'success',
            'message' => 'Data entry found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $service)
    {
        $validation = Validator::make($request->all(), [
            'action' => 'required|string|in:approved,denied',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        $service->update([
            'status' => $request->action,
        ]);

        return response()->json([
            'data' => new ServiceResource($service),
            'status' => 'success',
            'message' => 'Service request updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($service)
    {
        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        $old = $service;
        $service->delete();

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Service entry deleted successfully!'
        ], 200);
    }
}
