<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


/**
     * @OA\Post(
     * path="/groups",
     *   tags={"Groups"},
     *   summary="Save  group",
     *   operationId="groups",
     *
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="deactivated",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean",
     *
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Group for Budget Head has been created successfully!",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
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
     *
     * )
     * )
    */
      /**
     * @OA\Get(
     *     path="/groups",
     *     tags={"Groups"},
     *      summary="Returns all groups on the system",
     *     description="Returns all groups on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Group")
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
     *     path="/groups/{id}",
     *     tags={"Groups"},
     *     summary="Get group by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="group id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Group for Budget Head details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Group")
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
     *     path="/groups/{id}/edit",
     *     tags={"Groups"},
     *      summary="Open form to edit group",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="group id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Group")
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
     *          description="Invalid group id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/groups/{id}",
     *     tags={"Groups"},
     *      summary="update group by database",
     *     description="Updates group in database",
     *     operationId="updateRole",
     *
     *    @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="label",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="deactivated",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean",
     *
     *      )
     * ),
     *
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
     *          description="Invalid group id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/groups/{id}",
     *     tags={"Groups"},
     *      summary="remove group from database",
     *     description="Deletes group in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="group id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Group deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Group")
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
     *          description="Invalid group id"
     *      )
     *
     * )
     *     )
     * )
     */
class GroupController extends Controller
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
        $groups = Group::all();

        if ($groups->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'No data found'
            ], 200);
        }
        return response()->json([
            'data' => $groups,
            'status' => 'success',
            'message' => 'Group list'
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
            'label' => 'required|string|max:255|unique:roles'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $group = Group::create([
            'name' => $request->name,
            'label' => Str::slug($request->name),
        ]);

        return response()->json([
            'data' => $group,
            'status' => 'success',
            'message' => 'This group has been created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        $group = Group::where('label', $group)->first();

        if (! $group) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This group could not be found!'
            ], 404);
        }
        return response()->json([
            'data' => $group,
            'status' => 'success',
            'message' => 'Fetched group successfully.'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($group)
    {
        $group = Group::where('label', $group)->first();

        if (! $group) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This group could not be found!'
            ], 404);
        }
        return response()->json([
            'data' => $group,
            'status' => 'success',
            'message' => 'Fetched group successfully.'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:roles',
            'deactivated' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $group = Group::where('label', $group)->first();

        if (! $group) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This group could not be found!'
            ], 404);
        }

        $group->update([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'deactivated' => $request->deactivated
        ]);

        return response()->json([
            'data' => $group,
            'status' => 'success',
            'message' => 'Data updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($group)
    {
        $group = Group::where('label', $group)->first();

        if (! $group) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This group could not be found!'
            ], 404);
        }
        $group->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data deleted successfully!'
        ], 200);
    }
}
