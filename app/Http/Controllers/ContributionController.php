<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Contribution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\ContributionResource;
// use App\Http\Resources\UserResource;


/**
     * @OA\Post(
     * path="/contributions",
     *   tags={"Contributions"},
     *   summary="Save  contribution",
     *   operationId="contributions",
     *
     *  @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="fee",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="number",
     *          format="double"
     *
     *
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="month",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="current",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     * ),
     * @OA\Parameter(
     *      name="previous",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="json",
     *
     *      )
     * ),
     *   @OA\Response(
     *      response=201,
     *       description="Contribution   has been created successfully!",
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
     *     path="/contributions",
     *     tags={"Contributions"},
     *      summary="Returns all contributions on the system",
     *     description="Returns all contributions on the system",
     *     operationId="findRoles",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contribution")
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
     *     path="/contributions/{id}",
     *     tags={"Contributions"},
     *     summary="Get contribution by id",
     *     description="Returns based on id ",
     *     operationId="showRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="contribution id to get",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Contribution for  details!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contribution")
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
     *     path="/contributions/{id}/edit",
     *     tags={"Contributions"},
     *      summary="Open form to edit contribution",
     *     description="Returns based on id ",
     *     operationId="editRole",
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="contribution id to edit",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contribution")
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
     *          description="Invalid contribution id"
     *      )
     *
     * )
     *     )
     * )
     */

           /**

     * @OA\Delete(
     *     path="/contributions/{id}",
     *     tags={"Contributions"},
     *      summary="remove contribution from database",
     *     description="Deletes contribution in database",
     *     operationId="updateRole",
     *
     *   @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="contribution id to delete",
     *         required=true,
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Contribution deleted successfully!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contribution")
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
     *          description="Invalid contribution id"
     *      )
     *
     * )
     *     )
     * )
     */
class ContributionController extends Controller
{

    protected $results = [];

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
        $contributions = Contribution::all();
        if ($contributions->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'success',
                'message' => 'No data found!'
            ], 200);
        }
        return response()->json([
            'data' => ContributionResource::collection($contributions),
            'status' => 'success',
            'message' => 'List of contributions'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    public function loadMemberContributions(Request $request)
    {
        //
    }

    public function creditUserAccounts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'members' => 'required|array'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix this errors before proceeding!'
            ], 500);
        }

        foreach($request->members as $user) {
            $member = User::where('staff_no', $user['membership_no'])->first();

            if ($member) {
                $member->wallet->current += $user['amount'];
                $member->wallet->save();
            }

            $this->results[] = $member;
        }

        return response()->json([
            'data' => UserResource::collection($this->results),
            'status' => 'success',
            'message' => 'Accounts credited successfully!!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Contribution $contribution
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($contribution)
    {
        $contribution = Contribution::find($contribution);
        if (! $contribution) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This contribution does not exist'
            ], 404);
        }

        return response()->json([
            'data' => new ContributionResource($contribution),
            'status' => 'success',
            'message' => 'Contribution found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contribution $contribution
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($contribution)
    {
        $contribution = Contribution::find($contribution);
        if (! $contribution) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This contribution does not exist'
            ], 404);
        }

        return response()->json([
            'data' => new ContributionResource($contribution),
            'status' => 'success',
            'message' => 'Contribution found'
        ], 200);
    }

    public function update(Request $request, $contribution)
    {
        // Code goes here...
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function editContribution(Request $request, $member)
    {
        $validation = Validator::make($request->all(), [
            'fee' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix this errors before proceeding!'
            ], 500);
        }

        $member = User::where('staff_no', $member)->first();

        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This member does not exist'
            ], 404);
        }

        $member->contribution->fee = $request->fee;
        $member->contribution->save();

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member contribution updated successfully!'
        ], 200);
    }

    public function memberBulkCredit(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contribution $contribution
     * @return void
     */
    public function destroy(Contribution $contribution)
    {
        //
    }
}
