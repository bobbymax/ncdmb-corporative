<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectController extends Controller
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
        $projects = Project::all();

        if ($projects->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => $projects,
            'status' => 'success',
            'message' => 'Project List'
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
            'agent_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'timeline' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 422);
        }

        $project = Project::create([
            'code' => "PRJ" . time(),
            'agent_id' => $request->agent_id,
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'timeline' => $request->timeline,
        ]);

        if (! $project) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Something went terribly wrong!'
            ], 500);
        }

        return response()->json([
            'data' => $project,
            'status' => 'success',
            'message' => 'Project has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($project)
    {
        $project = Project::where('label', $project)->first();

        if (! $project) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The project token is invalid'
            ], 422);
        }

        return response()->json([
            'data' => $project,
            'status' => 'success',
            'message' => 'Project details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($project)
    {
        $project = Project::where('label', $project)->first();

        if (! $project) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The project token is invalid'
            ], 422);
        }

        return response()->json([
            'data' => $project,
            'status' => 'success',
            'message' => 'Project details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|integer',
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 422);
        }

        $project = Project::where('label', $project)->first();

        if (! $project) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The project token is invalid'
            ], 422);
        }

        $project->update([
            'agent_id' => $request->agent_id,
            'title' => $request->title,
            'label' => Str::slug($request->title),
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'timeline' => $request->timeline,
        ]);

        return response()->json([
            'data' => $project,
            'status' => 'success',
            'message' => 'Project has been created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($project)
    {
        $project = Project::where('label', $project)->first();

        if (! $project) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'The project token is invalid'
            ], 422);
        }

        $project->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Project has been deleted successfully!'
        ], 200);
    }
}
