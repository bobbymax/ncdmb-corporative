<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
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
        $agents = Agent::all();

        if ($agents->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }

        return response()->json([
            'data' => $agencies,
            'status' => 'success',
            'message' => 'Vendor list'
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string',
            'short_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $agent = Agent::create([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'short_name' => $request->short_name,
            'code' => Str::random(8),
        ]);

        if (! $agent) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Something went terribly wrong!'
            ], 500);
        }

        return response()->json([
            'data' => $agent,
            'status' => 'success',
            'message' => 'Vendor record has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show($agent)
    {
        $agent = Agent::where('label', $agent)->first();

        if (! $agent) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid vendor token'
            ], 422);
        }

        return response()->json([
            'data' => $agent,
            'status' => 'success',
            'message' => 'Vendor details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        $agent = Agent::where('label', $agent)->first();

        if (! $agent) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid vendor token'
            ], 422);
        }

        return response()->json([
            'data' => $agent,
            'status' => 'success',
            'message' => 'Vendor details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agent)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $agent = Agent::where('label', $agent)->first();

        if (! $agent) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid vendor token'
            ], 422);
        }

        $agent->update([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'short_name' => $request->short_name
        ]);

        return response()->json([
            'data' => $agent,
            'status' => 'success',
            'message' => 'Vendor record has been created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy($agent)
    {
        $agent = Agent::where('label', $agent)->first();

        if (! $agent) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid vendor token'
            ], 422);
        }

        $agent->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Vendor record has been deleted successfully!'
        ], 200);
    }
}
