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
use App\Imports\MemberImport;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Excel;

 /**
     * @OA\Post(
     * path="/import/members",
     *   tags={"Members"},
     *   summary="Import Members from Excel File",
     *   operationId="importMembers",
     *
     *
     *   @OA\Parameter(
     *      name="file",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *             format="byte"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Members records have been created successfully",
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
     * @OA\Post(
     * path="/reset/password",
     *   tags={"Members"},
     *   summary="Reset User Password",
     *   operationId="resetPassword",
     *
     *
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Password has been updated successfully",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
        * @OA\Response(
     *         response=422,
     *         description="Invalud User Request",
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
     * @OA\Post(
     * path="/members",
     *   tags={"Members"},
     *   summary="Save Member",
     *   operationId="members",
     *
     *  @OA\Parameter(
     *      name="staff_no",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="designation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="firstname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="middlename",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="surname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="mobile",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="location",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *            enum={"member","exco"}
     *
     *
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="date_joined",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="date"
     *      )
     * ),
     * @OA\Parameter(
     *      name="can_guarantee",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="has_loan",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean",
     *
     *      )
     * ),
     *
     * @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *         enum={"active", "inactive"},
     *      )
     * ),
     *  @OA\Parameter(
     *      name="email_verified_at",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="date",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     * * @OA\Parameter(
     *      name="remember_token",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     * * @OA\Parameter(
     *      name="avatar",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     *
     *
     *   @OA\Response(
     *      response=201,
     *       description="Member   has been created successfully!",
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
     *     path="/members",
     *     tags={"Members"},
     *      summary="Returns all members on the system",
     *     description="Returns all members on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Member")
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
     *     path="/members/{id}",
     *     tags={"Members"},
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
     *         description="Member for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Member")
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
     *     path="/members/{id}/edit",
     *     tags={"Members"},
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
     *             @OA\Items(ref="#/components/schemas/Member")
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
     *     path="/members/{id}",
     *     tags={"Members"},
     *      summary="update specification by database",
     *     description="Updates specification in database",
     *     operationId="updateRole",
     *
     *      *  @OA\Parameter(
     *      name="staff_no",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="designation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="firstname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="middlename",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="surname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *
     *  @OA\Parameter(
     *      name="mobile",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="location",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *
     *
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *            enum={"member","exco"}
     *
     *
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="date_joined",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="date"
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
     *     path="/members/{id}",
     *     tags={"Members"},
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
     *         description="Member deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Member")
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

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }


    public function importMembers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the error!'
            ], 500);
        }

        $members = Excel::import(new MemberImport, $request->file);

        return response()->json([
            'data' => UserResource::collection($members),
            'status' => 'success',
            'message' => 'Members records have been created successfully!'
        ], 201);
    }

    public function passwordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string'
        ]);

        $user = User::find($request->loggedInUser);

        if (! $user || auth()->user()->id != $user->id) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid user request'
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->passwordChange = true;
        $user->save();

        return response()->json([
            'data' => new UserResource(auth()->user()),
            'status' => 'success',
            'message' => 'Password has been updated successfully!!'
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $members = User::latest()->get();

        if ($members->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ], 200);
        }

        return response()->json([
            'data' => UserResource::collection($members),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'staff_no' => 'required|unique:users',
            'designation' => 'required|string|max:255',
            'mobile' => 'required|unique:users',
            'type' => 'required|string|in:member,exco',
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'phone' => 'required',
            'bank_name' => 'required|string|max:255',
            'fee' => 'required|numeric',
            'account_number' => 'required|string|max:15|unique:wallets',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors before proceeding'
            ], 500);
        }

        $kin_mobile_exists = Kin::where('mobile', $request->mobile)->get();
        if ($kin_mobile_exists->count() >= 1) {
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'This mobile already exists'
            ], 422);
        }

        $password = Str::slug($request->firstname . "." . $request->surname);

        $member = User::create([
            'staff_no' => $request->staff_no,
            'membership_no' => $request->staff_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($password),
            'designation' => $request->designation,
            'mobile' => $request->mobile,
            'type' => $request->type,
            'date_joined' => Carbon::parse($request->date_joined),
        ]);

        if ($request->fee !== null) {
            $contribution = Contribution::create([
                'user_id' => $member->id,
                'fee' => $request->fee,
                'month' => now()->month,
                'current' => true
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

        if (!$role) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user)
    {
        $member = User::with(['roles', 'kin', 'contribution', 'wallet'])->where('staff_no', $user)->first();
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }
        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($user)
    {
        $member = User::where('staff_no', $user)->first();
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }
        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member found'
        ], 200);
    }

    public function modifyAccount(Request $request, $member)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:member,exco',
            'membership_no' => 'required|string',
            'date_joined' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors before proceeding'
            ], 500);
        }

        $member = User::find($member);
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }

        $member->update([
            'membership_no' => $request->membership_no,
            'type' => $request->type,
            'date_joined' => Carbon::parse($request->date_joined)
        ]);

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member account has been modified successfully!'
        ], 200);
    }

    public function modifyMemberContribution(Request $request, $member)
    {
        $validator = Validator::make($request->all(), [
            'fee' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors before proceeding'
            ], 500);
        }

        $member = User::find($member);
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }

        $previousContribution = Contribution::where('user_id', $member->id)->where('current', true)->first();

        if ($previousContribution) {
            $contribution = new Contribution;
            $contribution->fee = $request->fee;
            $contribution->current = true;
            $contribution->month = Carbon::now()->format('F');
            $member->contributions()->save($contribution);

            $previousContribution->current = false;
            $previousContribution->save();
        }

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member contribution has been modified successfully!'
        ], 200);
    }

    public function verifyMemberAccount($member)
    {
        $member = User::find($member);
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }

        $member->update([
            'status' => 'active'
        ]);

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member account has been verified successfully!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'staff_no' => 'required',
            'email' => 'required|string|max:255',
            // 'location' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile' => 'required',
            // 'type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors before proceeding'
            ], 500);
        }

        $member = User::find($user);
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }

        $member->update([
            'staff_no' => $request->staff_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'surname' => $request->surname,
            'email' => $request->email,
            // 'location' => $request->location,
            'designation' => $request->designation,
            'mobile' => $request->mobile,
            // 'type' => $request->type,
            // 'date_joined' => Carbon::parse($request->date_joined),
        ]);

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member has been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        $member = User::where('staff_no', $user)->first();
        if (!$member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
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

    public function generateNumber()
    {
        return response()->json(
            [
                'data' => [],
                'number' => LoanUtilController::generateCode(6),
                'status' => 'success'
            ]
        );
    }

    public function assignNumber(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "staff_no" => 'required',
            'membership_no' => 'required|min:6',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 422);
        }

        // check if staff number exists
        $member = User::where('staff_no', $request->staff_no)->where('membership_no', null)->orWhere('membership_no', "")->update(['membership_no' => $request->membership_no]);

        if ($member < 1) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid request'
            ], 422);
        } else {
            return response()->json([
                'data' => null,
                'status' => 'success',
                'message' => 'Membership number assigned successfully'
            ], 200);
        }

        // LoanUtilController::generateCode();
    }
}
