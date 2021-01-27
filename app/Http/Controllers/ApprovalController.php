<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApprovalResource;
use App\Http\Resources\LoanResource;
use App\Models\Approval;
use App\Models\Guarantor;
use App\Models\Loan;
use Illuminate\Http\Request;

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
        $loan_id = Guarantor::where('user_id', $request->user()->id)->get('loan_id');
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
        $user_id = $request->user()->id;
        $loan_has_guarantor = Loan::where(
            ['user_id', $user_id],
            ['code', $request->loan],
            ['status', 'pending'],
        );
    }

    public function rejectApproval(Request $request)
    {
        return response()->json([
            'resp' => $request->loan
        ]);
    }
}
