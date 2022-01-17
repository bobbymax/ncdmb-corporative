<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use App\Models\Beneficiary;
use App\Models\Agent;
use App\Models\User;
use App\Models\Project;
use App\Helpers\Identifier;
use App\Http\Resources\PayResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

/**
     * @OA\Post(
     * path="/payments",
     *   tags={"Payments"},
     *   summary="Save  payment",
     *   operationId="payments",
     *
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="beneficiary_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="trxRef",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="payable_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="payable_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *   @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *   @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *   @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="float"
     *      )
     * ),
     *
     *   @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          enum={"member", "staff", "third-party"}
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Payment   has been created successfully!",
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
     *     path="/payments",
     *     tags={"Payments"},
     *      summary="Returns all payments on the system",
     *     description="Returns all payments on the system",
     *     operationId="findPayments",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pay")
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
     *     path="/payments/{id}",
     *     tags={"Payments"},
     *     summary="Get payment by id",
     *     description="Returns based on id ",
     *     operationId="showPayment",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="payment id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permission for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pay")
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
     *     path="/payments/{id}/edit",
     *     tags={"Payments"},
     *      summary="Open form to edit payment",
     *     description="Returns based on id ",
     *     operationId="editPayment",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="payment id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pay")
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
     *          description="Invalid payment id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/payments/{id}",
     *     tags={"Payments"},
     *      summary="update payment by database",
     *     description="Updates payment in database",
     *     operationId="updatePayment",
     *
     *
     *   @OA\Parameter(
     *      name="name",
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
     *      name="slots",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="deactivated",
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
     *          description="Invalid payment id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/payments/{id}",
     *     tags={"Payments"},
     *      summary="remove payment from database",
     *     description="Deletes payment in database",
     *     operationId="updatePayment",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="payment id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permission deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pay")
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
     *          description="Invalid payment id"
     *      )
     *
     * )
     *     )
     * )
     */
class PayController extends Controller
{
    protected $beneficiary, $identity, $sector;

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
        $payments = Pay::all();

        if ($payments->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => PayResource::collection($payments),
            'status' => 'success',
            'message' => 'Payment List'
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
     * Get Beneficiary for payment
     */
    public function identifyBeneficiary($type)
    {
        if (!in_array($type, config('corporative.payment.types'))) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid payment type'
            ], 422);
        }

        return response()->json([
            'data' => $this->getBeneficiary($type),
            'status' => 'success',
            'message' => 'Beneficiary list'
        ], 200);
    }

    private function getBeneficiary($type)
    {
        switch ($type) {
            case "third-party":
                return Agent::all();
                break;

            default:
                return User::latest()->get();
                break;
        }
    }

    public function getDependencies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required',
            'method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix this errors'
            ], 500);
        }

        return response()->json([
            'data' => $this->splitter($request->all()),
            'status' => 'success',
            'message' => 'Beneficiary dependencies'
        ], 200);
    }

    private function splitter(array $data)
    {
        switch ($data['method']) {
            case "project":
                $beneficiary = Agent::where('code', $data['identifier'])->first();
                return $beneficiary->projects;
                break;

            default:
                $beneficiary = User::where('staff_no', $data['identifier'])->first();
                return $beneficiary->loans;
                break;
        }
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
            'identifier' => 'required',
            'code' => 'required',
            'title' => 'required|string|unique:pays|max:255',
            'amount' => 'required|integer',
            'type' => 'required|string|in:member,staff,third-party',
            'method' => 'required|string|in:loan,project'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 422);
        }

        if ($request->payment_code !== null) {
            $this->beneficiary = Beneficiary::where('payment_code', $request->payment_code)->first();
        } else {
            $this->identity = (new Identifier($request->type, $request->identifier, $request->method, $request->code))->init();

            if (!is_object($this->identity->beneficiary)) {
                $this->beneficiary = new Beneficiary;
                $this->beneficiary->payment_code = "BEN" . time();
                $this->identity->beneficiary()->save($this->beneficiary);
            } else {
                $this->beneficiary = $this->identity;
            }
        }


        $this->sector = (new Identifier($request->type, $request->identifier, $request->method, $request->code))->meth();

        $payment = new Pay;
        $payment->user_id = $request->user()->id;
        $payment->beneficiary_id = $this->beneficiary->id;
        $payment->trxRef = "PYMT" . time();
        $payment->title = $request->title;
        $payment->label = Str::slug($request->title);
        $payment->amount = $request->amount;
        $payment->type = $request->type;

        $this->sector->payments()->save($payment);

        return response()->json([
            'data' => new PayResource($payment),
            'status' => 'success',
            'message' => 'Payment has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay  $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($payment)
    {
        $payment = Pay::where('trxRef', $payment)->first();

        if (! $payment) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The transaction code is invalid'
            ], 422);
        }

        return response()->json([
            'data' => new PayResource($payment),
            'status' => 'success',
            'message' => 'Payment details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pay  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pay $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay $payment)
    {
        //
    }
}
