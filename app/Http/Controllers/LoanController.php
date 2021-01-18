<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\LoanResource;

class LoanController extends Controller
{
    protected $guarantors = [];

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
        $loans = Loan::all();
        if ($loans->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => new LoanResource($loans),
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'code' => 'required|string|max:255|unique:loans',
            'amount' => 'required|integer',
            'reason' => 'required|string|max:255',
            'start_date' => 'required|date',
            'description' => 'required|min:5',
            'guarantors' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $loan = Loan::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'code' => $request->code,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'description' => $request->description
        ]);

        if ($loan) {
            foreach ($request->guarantors as $guarantor) {
                $member = User::where('staff_no', $guarantor)->first();

                if (! $member) {
                    return response()->json([
                        'data' => null,
                        'status' => 'error',
                        'message' => 'You have entered an invalid member entry!'
                    ], 500);
                }

                $guarantor = Guarantor::create([
                    'loan_id' => $loan->id,
                    'user_id' => $member->id,
                ]);

                $this->guarantors[] = $guarantor->member->name;
            }
        }

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
     * @return \Illuminate\Http\Response
     */
    public function show($loan)
    {
        $loan = Loan::where('code', $loan)->first();
        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $loan,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $loan = Loan::where('code', $loan)->first();
        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $loan,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $loan)
    {
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'amount' => 'required|integer',
            'reason' => 'required|string|max:255',
            'start_date' => 'required|date',
            'description' => 'required|min:5',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $loan = Loan::where('code', $loan)->first();
        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found!'
            ], 200);
        }

        $loan->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'description' => $request->description
        ]);

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Loan has been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($loan)
    {
        $loan = Loan::where('code', $loan)->first();
        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
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
        $loan->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }
}
