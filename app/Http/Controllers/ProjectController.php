<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;


 /**
     * @OA\Post(
     * path="/projects",
     *   tags={"Projects"},
     *   summary="Save Project",
     *   operationId="saveProject",
     *
     *
     *   @OA\Parameter(
     *      name="agent_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer",
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="path",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="start_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="date",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="end_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="date",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="number",
     *             format="double"
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="timeline",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *          enum={"pending", "in-progress", "in-review", "verified", "completed"}
     *
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Projects records have been created successfully",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
        * @OA\Response(
     *         response=500,
     *         description="Please fix the error",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     *
     * )
     * )
    */


      /**
     * @OA\Get(
     *     path="/projects",
     *     tags={"Projects"},
     *      summary="Returns all projects on the system",
     *     description="Returns all projects on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
       * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     * )
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/projects/{id}",
     *     tags={"Projects"},
     *     summary="Get specification by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="specification id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Project for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     *      @OA\Response(
     *          response=422,
     *          description="This ID is invalid"
     *      )
     *
     * )
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/projects/{id}/edit",
     *     tags={"Projects"},
     *      summary="Open form to edit specification",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="specification id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *
     *     ),
     *     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid specification id"
     *      )
     *
     * )
     *     )
     * )
     */

                /**
     * @OA\Put(
     *     path="/projects/{id}",
     *     tags={"Projects"},
     *      summary="update specification by database",
     *     description="Updates specification in database",
     *     operationId="updateRole",
     *
     *
     *   @OA\Parameter(
     *      name="agent_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     * @OA\Parameter(
     *      name="timeline",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer",
     *
     *      )
     *   ),
     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid specification id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/projects/{id}",
     *     tags={"Projects"},
     *      summary="remove specification from database",
     *     description="Deletes specification in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="specification id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *
     *     ),
     * @OA\Response(
     *         response=500,
     *         description="Error, please fix the following error(s)!;",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     ),
     * @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid specification id"
     *      )
     *
     * )
     *     )
     * )
     */

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
            'title' => 'required|string|max:255|unique:projects',
            'timeline' => 'required|int',
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
            'amount' => $request->amount,
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
            'timeline' => 'required|int|max:255',
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
