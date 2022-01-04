<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Transactee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\LoanResource;


/**
     * @OA\Post(
     * path="/schedules",
     *   tags={"Schedules"},
     *   summary="Save  schedule",
     *   operationId="schedules",
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
     *      name="budget_head_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="double"
     *      )
     * ),
     * @OA\Parameter(
     *      name="reason",
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
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          enum={"pending", "registered", "approved", "denied", "disbursed", "closed"}
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="level",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="guaranteed",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *
     *      )
     * ),
     *  @OA\Parameter(
     *      name="closed",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean",
     *
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Schedule   has been created successfully!",
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
     *     path="/schedules",
     *     tags={"Schedules"},
     *      summary="Returns all schedules on the system",
     *     description="Returns all schedules on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Schedule")
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
     *     path="/schedules/{id}",
     *     tags={"Schedules"},
     *     summary="Get schedule by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="schedule id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Schedule for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Schedule")
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
     *     path="/schedules/{id}/edit",
     *     tags={"Schedules"},
     *      summary="Open form to edit schedule",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="schedule id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Schedule")
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
     *          description="Invalid schedule id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/schedules/{id}",
     *     tags={"Schedules"},
     *      summary="update schedule by database",
     *     description="Updates schedule in database",
     *     operationId="updateRole",
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
     *          description="Invalid schedule id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/schedules/{id}",
     *     tags={"Schedules"},
     *      summary="remove schedule from database",
     *     description="Deletes schedule in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="schedule id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Schedule deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Schedule")
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
     *          description="Invalid schedule id"
     *      )
     *
     * )
     *     )
     * )
     */
class ScheduleController extends Controller
{


    protected $types = ['credit', 'debit'];

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
        $schedules = Schedule::latest()->get();
        if ($schedules->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }
        return response()->json([
            'data' => $schedules,
            'status' => 'success',
            'message' => 'Data found'
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
            'loan' => 'required|string|max:255',
            'schedules' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors:'
            ], 500);
        }


        $loan = Loan::where('code', $request->loan)->first();

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This loan detail was not found'
            ], 404);
        }

        foreach ($request->schedules as $detail) {
            $due = explode(" : ", $detail);

            $schedule = new Schedule;
            $schedule->due_date = Carbon::parse($due[0]);
            $schedule->amount = $due[1];

            $loan->schedules()->save($schedule);
        }

        $loan->status = "disbursed";
        $loan->save();

//        if ($loan->save()) {
//            $transaction = new Transaction;
//            $transaction->code = "LN" . time() . strtoupper(Str::random(5));
//            $transaction->type = "loan";
//            $transaction->amount = $loan->amount;
//
//            if ($loan->transactions()->save($transaction)) {
//                foreach ($this->types as $type) {
//                    $transactee = new Transactee;
//                    $transactee->user_id = $this->setType($type, $loan)[0];
//                    $transactee->type = $type;
//                    $transactee->status = $this->setType($type, $loan)[1];
//
//                    $transaction->transactees()->save($transactee);
//                }
//            }
//        }

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Schedule created successfully!'
        ], 201);
    }

    protected function setType($type, Loan $loan)
    {
        switch ($type) {
            case "credit":
                return [$loan->member->id, "receiver"];
                break;

            default:
                return [auth()->user()->id, "sender"];
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show($schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $schedule)
    {
        $schedule = Schedule::find($schedule);

        if (! $schedule) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid data input!'
            ], 404);
        }

        $schedule->update([
            'status' => $request->status
        ]);

        return response()->json([
            'data' => $schedule,
            'status' => 'success',
            'message' => 'Schedule updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
