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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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

        if ($loan->save()) {
            $transaction = new Transaction;
            $transaction->code = "LN" . time() . strtoupper(Str::random(5));
            $transaction->type = "loan";
            $transaction->amount = $loan->amount;

            if ($loan->transactions()->save($transaction)) {

                foreach ($this->types as $type) {
                    $transactee = new Transactee;
                    $transactee->user_id = $this->setType($type, $loan)[0];
                    $transactee->type = $type;
                    $transactee->status = $this->setType($type, $loan)[1];

                    $transaction->transactees()->save($transactee);
                }
            }
        }

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
     * @return \Illuminate\Http\Response
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
