<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


/**
     * @OA\Post(
     * path="/permissions",
     *   tags={"Permissions"},
     *   summary="Save  permission",
     *   operationId="permissions",
     *
     *
     *   @OA\Parameter(
     *      name="key",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="module",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Permission   has been created successfully!",
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
     *     path="/permissions",
     *     tags={"Permissions"},
     *      summary="Returns all permissions on the system",
     *     description="Returns all permissions on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *     path="/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Get permission by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="permission id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permission for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *     path="/permissions/{id}/edit",
     *     tags={"Permissions"},
     *      summary="Open form to edit permission",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="permission id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *          description="Invalid permission id"
     *      )
     *
     * )
     *     )
     * )
     */


                /**
     * @OA\Put(
     *     path="/permissions/{id}",
     *     tags={"Permissions"},
     *      summary="update permission by database",
     *     description="Updates permission in database",
     *     operationId="updateRole",
     *
     *    @OA\Parameter(
     *      name="budget_head_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="approved_amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          format="double"
     *      )
     * ),
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
     *          description="Invalid permission id"
     *      )
     *
     * )
     *     )
     * )
     */

                     /**
     * @OA\Delete(
     *     path="/permissions/{id}",
     *     tags={"Permissions"},
     *      summary="remove permission from database",
     *     description="Deletes permission in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="permission id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permission deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
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
     *          description="Invalid permission id"
     *      )
     *
     * )
     *     )
     * )
     */
class PermissionController extends Controller
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
        $permissions = Permission::all();

        if ($permissions->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'success',
                'message' => 'There are no permissions stored at this time!!'
            ], 200);
        }
        return response()->json([
            'data' => $permissions,
            'status' => 'success',
            'message' => 'List of permissions'
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
            'key' => 'required|string|max:255|unique:permissions',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $permission = Permission::create([
            'name' => $request->name,
            'key' => Str::slug($request->name),
            'module' => $request->module
        ]);

        return response()->json([
            'data' => $permission,
            'status' => 'success',
            'message' => 'Permission created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($permission)
    {
        $permission = Permission::find($permission);

        if (! $permission) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please enter a valid permissions ID'
            ], 500);
        }

        return response()->json([
            'data' => $permission,
            'status' => 'success',
            'message' => 'Permission fetched successfully!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($permission)
    {
        $permission = Permission::find($permission);

        if (! $permission) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please enter a valid permissions ID'
            ], 500);
        }

        return response()->json([
            'data' => $permission,
            'status' => 'success',
            'message' => 'Permission fetched successfully!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $permission = Permission::find($permission);

        if (! $permission) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please enter a valid permissions ID'
            ], 500);
        }

        $permission->update([
            'name' => $request->name,
            'key' => Str::slug($request->name),
            'module' => $request->module
        ]);

        return response()->json([
            'data' => $permission,
            'status' => 'success',
            'message' => 'Permission updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($permission)
    {
        $permission = Permission::find($permission);

        if (! $permission) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid entry'
            ], 500);
        }

        $old = $permission->name;

        $permission->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => $old . ' has been deleted successfully.
            '], 200);
    }
}
