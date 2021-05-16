<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
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
    public function index()
    {
        $journals = Journal::all();

        if ($journals->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 204);
        }
        return response()->json([
            'data' => $journals,
            'status' => 'success',
            'message' => 'Journal List'
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
        $validator = Validator::make($request->all(), [
            'account_code_id' => 'required|integer',
            'budget_head_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'entry_date' => 'required|date',
            'amount' => 'required',
            'description' => 'required|min:3',
            'payment_type' => 'required|in:credit,debit',
            'payment_methods' => 'required|in:electronic,check,cash',
            'entries' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $journal = Journal::create([
            'account_code_id' => $request->account_code_id,
            'budget_head_id' => $request->budget_head_id,
            'name' => $request->name,
            'entry_date' => Carbon::parse($request->entry_date),
            'amount' => $request->amount,
            'description' => $request->description,
            'payment_type' => $request->payment_type,
            'payment_methods' => $request->payment_methods,
        ]);

        if ($journal && $request->has('entries')) {
            foreach ($request->entries as $value) {
                $entry = new Entry;

                $entry->journal_id = $journal->id;
                $entry->payment_type = $value['payment_type'];
                $entry->amount = $value['amount'];
                $entry->entryable()->save($value['object']);
            }
        }

        return response()->json([
            'data' => $journal,
            'status' => 'success',
            'message' => 'Journal entries have been created successfully!!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($journal)
    {
        $journal = Journal::find($journal);

        if (! $journal) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid code entered'
            ], 422);
        }

        return response()->json([
            'data' => $journal,
            'status' => 'success',
            'message' => 'Journal details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($journal)
    {
        $journal = Journal::find($journal);

        if (! $journal) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid code entered'
            ], 422);
        }

        return response()->json([
            'data' => $journal,
            'status' => 'success',
            'message' => 'Journal details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
