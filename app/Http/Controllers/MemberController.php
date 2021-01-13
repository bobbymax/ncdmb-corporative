<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kin;
use App\Models\Wallet;
use App\Models\Role;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = User::with(['roles', 'kin', 'contribution', 'wallet']);
        $resource = UserResource::collection($members->latest()->get());
        if ($resource->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => $resource,
            'status' => 'success',
            'message' => 'List of members'
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
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'staff_no' => 'required|unique:users',
            'location' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile' => 'required|unique:users',
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:15|unique:wallets',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'danger',
                'message' => 'Please fix the following errors before proceeding'
            ], 500);
        }

        $member = User::create([
            'staff_no' => $request->staff_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
            'designation' => $request->designation,
            'mobile' => $request->mobile,
            'type' => $request->type,
            'date_joined' => Carbon::parse($request->date_joined),
        ]);

        if ($request->fee !== null) {
            $contribution = Contribution::create([
                'user_id' => $member->id,
                'fee' => $request->fee
            ]);
        }

        if ($request->name !== null) {
            $kin = Kin::create([
                'user_id' => $member->id,
                'name' => $request->name,
                'relationship' => $request->relationship,
                'mobile' => $request->phone,
                'address' => $request->address,
            ]);
        }

        if ($request->bank_name) {
            $wallet = Wallet::create([
                'user_id' => $member->id,
                'identifier' => Str::random(12),
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number
            ]);
        }

        $role = Role::where('label', 'member')->first();

        if (! $role) {
            $role = Role::create([
                'name' => 'Member',
                'label' => 'member',
                'slots' => 1000
            ]);
        }

        $role->members()->save($member);

        return response()->json([
            'data' => $member,
            'status' => 'success',
            'message' => 'Member has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $member = User::where('staff_no', $user)->first();
        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This member does not exist'
            ], 404);
        }
        return response()->json([
            'data' => $member,
            'status' => 'success',
            'message' => 'Member found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $member = User::where('staff_no', $user)->first();
        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This member does not exist'
            ], 404);
        }
        return response()->json([
            'data' => $member,
            'status' => 'success',
            'message' => 'Member found'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'staff_no' => 'required',
            'location' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile' => 'required',
            'type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'danger',
                'message' => 'Please fix the following errors before proceeding'
            ], 500);
        }

        $member = User::where('staff_no', $user)->first();
        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This member does not exist'
            ], 404);
        }

        $member->update([
            'staff_no' => $request->staff_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'surname' => $request->surname,
            'location' => $request->location,
            'designation' => $request->designation,
            'mobile' => $request->mobile,
            'type' => $request->type,
            'date_joined' => Carbon::parse($request->date_joined),
        ]);

        return response()->json([
            'data' => $member,
            'status' => 'success',
            'message' => 'Member has been created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $member = User::where('staff_no', $user)->first();
        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'This member does not exist'
            ], 404);
        }
        $member->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Member has been deleted successfully!'
        ], 200);

    }
}
