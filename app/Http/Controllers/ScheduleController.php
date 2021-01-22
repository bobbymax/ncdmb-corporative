<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\LoanResource;

class ScheduleController extends Controller
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
                'status' => 'danger',
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

        return response()->json([
            'data' => new LoanResource($loan),
            'status' => 'success',
            'message' => 'Schedule created successfully!'
        ], 201);
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
                'status' => 'danger',
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
