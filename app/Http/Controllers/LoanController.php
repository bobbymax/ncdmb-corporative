<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Guarantor;
use App\Models\Sponsor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Resources\LoanResource;
use Illuminate\Support\Facades\Validator;
use DB;


/**
     * @OA\Post(
     * path="/loans",
     *   tags={"Loans"},
     *   summary="Save  loan",
     *   operationId="loans",
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
     *       description="Loan   has been created successfully!",
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
     *     path="/loans",
     *     tags={"Loans"},
     *      summary="Returns all loans on the system",
     *     description="Returns all loans on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Loan")
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
     *     path="/loans/{id}",
     *     tags={"Loans"},
     *     summary="Get loan by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="loan id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Loan for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Loan")
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
     *     path="/loans/{id}/edit",
     *     tags={"Loans"},
     *      summary="Open form to edit loan",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="loan id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Loan")
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
     *          description="Invalid loan id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/loans/{id}",
     *     tags={"Loans"},
     *      summary="update loan by database",
     *     description="Updates loan in database",
     *     operationId="updateRole",
     *
     *
     * @OA\Parameter(
     *      name="budget_head_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),

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
     *         description="Loan has been updated successfully",
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
     *          description="Invalid loan id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/loans/{id}",
     *     tags={"Loans"},
     *      summary="remove loan from database",
     *     description="Deletes loan in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="loan id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Loan deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Loan")
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
     *          description="Invalid loan id"
     *      )
     *
     * )
     *     )
     * )
     */
class LoanController extends Controller
{
    protected $guarantors = [];

    protected $counter = 0;

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
        $loans = Loan::all();

        if ($loans->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data was found!'
            ], 200);
        }
        return response()->json([
            'data' => LoanResource::collection($loans),
            'status' => 'success',
            'message' => 'Data found!'
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
            'budget_head_id' => 'required|integer',
            'amount' => 'required|integer',
            'reason' => 'required|string|max:255',
            'guarantors' => 'required|array',
            'code' => 'required|string|unique:loans',
            'instructions' => 'required|array',
            'capitalSum' => 'required',
            'committment' => 'required',
            'interestSum' => 'required',
            'totalPayable' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        if (count($request->guarantors) != 3) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'You can only select 3 guarantors'
            ], 422);
        }

        $loan = Loan::create([
            'user_id' => auth()->user()->id,
            'budget_head_id' => $request->budget_head_id,
            'code' => $request->code,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'capitalSum' => $request->capitalSum,
            'committment' => $request->committment,
            'interestSum' => $request->interestSum,
            'totalPayable' => $request->totalPayable,
        ]);

        if ($loan) {
            $dataChunk = [];
            foreach ($request->guarantors as $guarantor) {
                $member = User::find($guarantor['value']);

                if (! $member) {
                    return response()->json([
                        'data' => null,
                        'status' => 'error',
                        'message' => 'You have entered an invalid member entry!'
                    ], 422);
                }

                $guarantor = new Guarantor;
                $guarantor->user_id = $member->id;
                $guarantor->loan_id = $loan->id;
                $guarantor->save();
            }

            foreach ($request->instructions as $instruction) {
                $insertData = [
                    'loan_id' => $loan->id,
                    'capital' => $instruction['capital'],
                    'installment' => $instruction['installment'],
                    'interest' => $instruction['interest'],
                    'interestSum' => $instruction['interestSum'],
                    'remain' => $instruction['remain'],
                    'due' => Carbon::parse($instruction['index']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                $dataChunk[] = $insertData;
            }

            $dataChunk = collect($dataChunk);
            $chunks = $dataChunk->chunk(100);
            $this->insertInto('instructions', $chunks);
        }



        // NotificationController::messageAfterLoanRequest([auth()->user()->mobile], $request->amount);

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Loan has been registered successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($loan)
    {
        $loan = Loan::find($loan);

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }
        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($loan)
    {
        $loan = Loan::find($loan);

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    public function getLoanFromCode($loan)
    {
        $loan = Loan::where('code', $loan)->first();

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $loan)
    {
        $validation = Validator::make($request->all(), [
            'amount' => 'required|integer',
            'previousAmount' => 'required|integer',
            'instructions' => 'required|array',
            'capitalSum' => 'required',
            'committment' => 'required',
            'interestSum' => 'required',
            'totalPayable' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $loan = Loan::find($loan);

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered!'
            ], 422);
        }

        $loan->update([
            'amount' => $request->amount,
            'previousAmount' => $request->previousAmount,
            'capitalSum' => $request->capitalSum,
            'committment' => $request->committment,
            'interestSum' => $request->interestSum,
            'totalPayable' => $request->totalPayable,
            'stage' => 'treasury-officer',
            'level' => 1
        ]);

        if ($request->amount != $request->previousAmount) {
            $loan->instructions()->delete();

            $dataChunk = [];

            foreach ($request->instructions as $instruction) {
                $insertData = [
                    'loan_id' => $loan->id,
                    'capital' => $instruction['capital'],
                    'installment' => $instruction['installment'],
                    'interest' => $instruction['interest'],
                    'interestSum' => $instruction['interestSum'],
                    'remain' => $instruction['remain'],
                    'due' => Carbon::parse($instruction['due']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                $dataChunk[] = $insertData;
            }

            $dataChunk = collect($dataChunk);
            $chunks = $dataChunk->chunk(100);
            $this->insertInto('instructions', $chunks);
        }

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Loan has been submitted for approval!'
        ], 200);
    }

    public function grantStat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan' => 'required|integer',
            'remarks' => 'required|string|min:3',
            'status' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 422);
        }

        $loan = Loan::find($request->loan);

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This input value is invalid'
            ], 422);
        }

        if ($loan->guarantors()->detach($request->user())) {
            $loan->guarantors()->attach($request->user(), [
                'remarks' => $request->remarks,
                'status' => $request->status,
            ]);

            $current = $request->user()->guaranteed()->wherePivot('status', 'approved')->get();

            if ($current->count() == 2) {
                $request->user()->can_guarantee = false;
                $request->user()->save();
            }
        }

        $this->counter = $loan->guarantors()->wherePivot('status', 'approved')->get();


        if ($this->counter->count() == 3) {

            // $loan->level += 1;
            // $loan->status = "registered";
            // $loan->save();
            $role = Role::where('label', config('corporative.loans.approvals.first'))->first();

            if (! $role) {
                return response()->json([
                    'data' => null,
                    'status' => 'error',
                    'message' => 'Invalid input'
                ], 422);
            }

            if ($loan->approvals()->save($role->members->first())) {
                $loan->level += 1;
                $loan->status = "registered";
                $loan->save();
            }

            // NotificationController::messageAfterLoanRegistered([$loan->member->mobile], $loan);
        }

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Loan status has been updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($loan)
    {
        $loan = Loan::find($loan);

        if (!$loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }
        if ($loan->status !== "pending") {
            return response()->json([
                'data' => null,
                'status' => 'warning',
                'message' => 'You are not permitted to delete an already existing loan!'
            ], 403);
        }
        $old = $loan;
        $loan->delete();

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Loan data deleted successfully!!'
        ], 200);
    }

    public function generateCode($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return 'ln' . $randomString;
    }

    public function loanApprovalList()
    {
        $roles = config('corporative.loans.approvals');
        $loans = collect();

        if (auth()->user()->hasRole($roles['first'])) {
            $loans = Loan::where('status', 'registered')->where('level', 1)->get();
        }
        if (auth()->user()->hasRole($roles['second'])) {
            $loans = Loan::where('status', 'registered')->where('level', 2)->get();
        }
        if (auth()->user()->hasRole($roles['third'])) {
            $loans = Loan::where('status', 'registered')->where('level', 3)->get();
        }
        if ($loans->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => LoanResource::collection($loans),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    protected function insertInto($table, $chunks)
    {
        foreach ($chunks as $chunk) {
            DB::table($table)->insert($chunk->toArray());
        }

        return;
    }
}
