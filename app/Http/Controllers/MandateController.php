<?php

namespace App\Http\Controllers;

use App\Models\Mandate;
use Illuminate\Http\Request;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Support\Facades\Validator;

class MandateController extends Controller
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
        //
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
        $validator = Validator::make($request->all(), [
            'level' => 'required|integer',
            'loan_id' => 'required|integer',
            'stage' => 'required|string',
            'status' => 'required|string|in:approved,declined'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $loan = Loan::find($request->loan_id);

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The loan code is invalid!!'
            ], 422);
        }

        $mandate = new Mandate;
        $mandate->user_id = auth()->user()->id;
        $mandate->status = $request->status;
        $mandate->remark = $request->remark;


        if ($loan->mandates()->save($mandate)) {
            $this->processLoanApproval($request->stage, $mandate, $loan);
        }


        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Loan mandate has been saved successfully!'
        ], 200);
    }

    protected function processLoanApproval($stage, Mandate $mandate, Loan $loan)
    {
        switch ($stage) {
            case 'general-secretary':
                if ($mandate->status === "approved") {
                    $loan->level = 3;
                    $loan->stage = "president";
                } else {
                    $loan->status = "denied";
                    $loan->closed = true;
                }
                $loan->save();
                break;

            case 'president':
                if ($mandate->status === "approved") {
                    $loan->status = "approved";
                    $loan->stage = "accounts-officer";
                    $loan->level = 4;
                } else {
                    $loan->status = "denied";
                    $loan->closed = true;
                }

                $loan->save();
                break;
            
            default:
                if ($mandate->status === "approved") {
                    $loan->level = 2;
                    $loan->stage = "general-secretary";
                } else {
                    $loan->status = "denied";
                    $loan->closed = true;
                }

                $loan->save();
                break;
        }

        return $loan;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mandate  $mandate
     * @return \Illuminate\Http\Response
     */
    public function show(Mandate $mandate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mandate  $mandate
     * @return \Illuminate\Http\Response
     */
    public function edit(Mandate $mandate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mandate  $mandate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mandate $mandate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mandate  $mandate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mandate $mandate)
    {
        //
    }
}
