<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Resources\LoanResource;
use Illuminate\Support\Facades\Validator;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::all()->sortByDesc("created_at");
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
            'code' => 'unique:loans',
            'amount' => 'required|integer',
            'reason' => 'required|string|max:255',
            'start_date' => 'required|date',
            'description' => 'required|min:5',
            'guarantors' => 'required',
        ]);

        if (count($request->guarantors) != 3) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'You can only select 3 guarantors'
            ], 422);
        }

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $loan = Loan::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'code' => 'ln' . LoanUtilController::generateCode(), //$request->code,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'start_date' => Carbon::parse($request->start_date),
            'description' => $request->description,
            'status' => 'pending'
        ]);

        if ($loan) {
            foreach ($request->guarantors as $guarantor) {
                $member = User::where('staff_no', $guarantor)->first();

                if (!$member) {
                    return response()->json([
                        'data' => null,
                        'status' => 'error',
                        'message' => 'You have entered an invalid member entry!'
                    ], 422);
                }

                $loan->guarantors()->attach($member);
            }
            // $loan->status = "registered";
            // $loan->save();
        }

        setlocale(LC_MONETARY, 'en_US');
        $message = "Hello, " . auth()->user()->firstname . " " . auth()->user()->lastname . " You've requested a loan of " . number_format($request->amount) . " from the NCDMB";
        NotificationController::message([auth()->user()->mobile], $message);

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
        if (!$loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $loan = Loan::where('code', $loan)->first();
        if (!$loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
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
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $loan = Loan::where('code', $loan)->first();
        if (!$loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
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

    public function grantStat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan' => 'required|string|max:255',
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

        $loan = Loan::where('code', $request->loan)->first();

        if (!$loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This input value is invalid'
            ], 422);
        }

        if ($loan->guarantors()->detach($request->user())) {
            $loan->guarantors()->attach($request->user(), [
                'remarks' => $request->remarks,
                'status' => $request->status
            ]);

            $current = $request->user()->guaranteed()->wherePivot('status', 'approved')->get();

            if ($current->count() == 2) {
                $request->user()->can_guarantee = false;
                $request->user()->save();
            }
        }

        $this->counter = $loan->guarantors()->wherePivot('status', 'approved')->get();


        if ($this->counter->count() == 3) {

            $role = Role::where('label', config('corporative.approvals.first'))->first();

            if (!$role) {
                return response()->json([
                    'data' => null,
                    'status' => 'error',
                    'message' => 'Invalid input'
                ], 422);
            }

            if ($loan->approvals()->save($role->members->first())) {
                // $loan->level += 1;
                $loan->status = "registered";
                $loan->save();
            }
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($loan)
    {
        $loan = Loan::where('code', $loan)->first();

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
        $loan->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data found!'
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
        $roles = config('corporative.approvals');
        $loans = collect();

        if (auth()->user()->hasRole($roles['first'])) {
            $loans = Loan::where('status', 'registered')->where('level', 0)->get();
        }
        if (auth()->user()->hasRole($roles['second'])) {
            $loans = Loan::where('status', 'registered')->where('level', 1)->get();
        }
        if (auth()->user()->hasRole($roles['third'])) {
            $loans = Loan::where('status', 'registered')->where('level', 2)->get();
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
}
