<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
