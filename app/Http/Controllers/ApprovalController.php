<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApprovalResource;
use App\Http\Resources\LoanResource;
use App\Models\Approval;
use App\Models\Guarantor;
use App\Models\Loan;
use App\Models\Receive;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApprovalController extends Controller
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
    public function index(Request $request)
    {
        $loan_id = Guarantor::where([
            ['user_id', $request->user()->id],
            ['status', 'pending']
        ])->get('guarantorable_id');

        return response()->json(
            ApprovalResource::collection(Loan::find($loan_id->pluck('guarantorable_id')))
        );
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
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function edit(Approval $approval)
    {
        //
    }

    public function approveLoan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan' => 'required',
            'description' => 'required|min:3',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $loan = Loan::where('code', $request->loan)->first();

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The loan code is invalid!!'
            ], 422);
        }

        $trail = new Trail;
        $trail->user_id = $request->user()->id;
        $trail->description = $request->description;
        $trail->action = $request->status;

        if (! $loan->trails()->save($trail)) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Oops something must have gone wrong!'
            ], 500);
        }

        $this->takeAction($request->user(), $loan, $request->status);

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Loan request has been updated successfully!'
        ], 200);
    }

    protected function takeAction(User $exco, Loan $loan, $status)
    {
        $roles = config('corporative.loans.approvals');

        switch ($roles) {

            case $exco->hasRole($roles['second']) :

                if ($status !== "approved") {
                    $loan->status = "denied";
                } else {
                    $loan->level += 1;
                }

                $loan->save();

                return $loan;
                break;

            case $exco->hasRole($roles['third']):

                if ($status !== "approved") {
                    $loan->status = "denied";
                } else {
                    $loan->level += 1;
                    $loan->status = $status;

                    $receiver = new Receive;
                    $receiver->identifier = time();
                    $loan->receivers()->save($receiver);
                }

                $loan->save();

                return $loan;
                break;

            default:
                if ($status !== "approved") {
                    $loan->status = "denied";
                } else {
                    $loan->level += 1;
                }

                $loan->save();

                return $loan;
                break;

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approval $approval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approval $approval)
    {
        //
    }

    public function updateGuarantor($user_id, $status)
    {
        Guarantor::where(
            [
                ['user_id', $user_id],
                ['status', 'pending']
            ]
        )->update(['status' => $status]);
    }
}
