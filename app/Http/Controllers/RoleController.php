<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;

class RoleController extends Controller
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
        $roles = Role::all();
        if ($roles->count() < 1) {
            return response()->json(['data' => null, 'status' => 'success', 'message' => 'No data found!'], 200);
        }
        return response()->json([
            'data' => $roles,
            'status' => 'success',
            'message' => 'List of roles'
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
            'name' => 'required|string|unique:roles|max:255',
            'label' => 'unique:roles'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $role = Role::create([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'slots' => $request->slots
        ]);

        return response()->json([
            'data' => $role,
            'status' => 'success',
            'message' => 'Role created successfully!'
        ], 201);
    }

    public function addMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_no' => 'required|string',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following error(s)!'
            ], 500);
        }

        $member = User::where('staff_no', $request->staff_no)->first();


        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Either the member of role input is invalid!'
            ], 500);
        }

        if (! is_array($request->roles)) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Send roles in array format'
            ]);
        }


        foreach ($request->roles as $value) {
            $role = Role::where('label', $value)->first();

            if (! $role) {
                return response()->json([
                    'data' => null,
                    'status' => 'error',
                    'message' => 'Role input is invalid!'
                ], 500);
            }

            if (! in_array($role->id, $member->currentRoles())) {
                $member->actAs($role);
            }
        }

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Role assigned to member successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($role)
    {
        $role = Role::where('label', $role)->first();
        if (!$role) {
            return response()->json([
                'data' => null,
                'status' => 'invalid',
                'message' => 'This role does not exist'
            ], 500);
        }
        return response()->json([
            'data' => $role,
            'status' => 'success',
            'message' => 'Data found successfully!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        $role = Role::where('label', $role)->first();
        if (!$role) {
            return response()->json([
                'data' => null,
                'status' => 'invalid',
                'message' => 'This role does not exist'
            ], 500);
        }
        return response()->json([
            'data' => $role,
            'status' => 'success',
            'message' => 'Data found successfully!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:roles'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $role = Role::where('label', $role)->first();
        if (!$role) {
            return response()->json([
                'data' => null,
                'status' => 'invalid',
                'message' => 'This role does not exist'
            ], 500);
        }

        $role->update([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'slots' => $request->slots
        ]);

        return response()->json([
            'data' => $role,
            'status' => 'success',
            'message' => 'Role has been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        $role = Role::where('label', $role)->first();
        if (!$role) {
            return response()->json([
                'data' => null,
                'status' => 'invalid',
                'message' => 'This role does not exist'
            ], 500);
        }

        if ($role->members !== null) {
            foreach ($role->members as $member) {
                $member->roles()->detach($role);
            }
        }

        $role->delete();
        return response()->json(['data' => null, 'status' => 'success', 'message' => 'Role deleted successfully'], 200);
    }
}
