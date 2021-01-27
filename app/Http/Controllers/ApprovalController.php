<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApprovalResource;
use App\Http\Resources\LoanResource;
use App\Models\Approval;
use App\Models\Guarantor;
use App\Models\Loan;
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loan_id = Guarantor::where([
            ['user_id', $request->user()->id],
            ['status', 'pending']
        ])->get('loan_id');
        return response()->json(
            ApprovalResource::collection(Loan::find($loan_id->pluck('loan_id')))
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

    public function acceptApproval(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'loan' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the errors!'
            ], 422);
        }

        $user_id = $request->user()->id;
        $approval = Loan::where(
            [
                ['user_id', $user_id],
                ['code', $request->loan],
                ['status', 'pending']
            ]
        )->orWhere('status', 'denied');

        if ($approval->get()->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 422);
        }

        // update loan status
        $approval->update([
            'status' => 'approved'
        ]);

        // update guarantor status
        $this->updateGuarantor($user_id, 'approved');

        return response()->json([
            'data' => $approval,
            'status' => 'success',
            'message' => 'You have approved this loan'
        ], 200);
    }

    public function rejectApproval(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'loan' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the errors!'
            ], 422);
        }

        $user_id = $request->user()->id;
        $approval = Loan::where(
            [
                ['user_id', $user_id],
                ['code', $request->loan],
                ['status', 'pending']
            ]
        )->orWhere('status', 'approved');

        if ($approval->get()->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 422);
        }

        // update loan status
        $approval->update([
            'status' => 'denied'
        ]);

        // update guarantor status
        $this->updateGuarantor($user_id, 'denied');

        return response()->json([
            'data' => $approval,
            'status' => 'success',
            'message' => 'You have rejected this loan'
        ], 200);
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
