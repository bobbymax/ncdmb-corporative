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

class ContributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
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

    /**
     * Display the specified resource.
     *
     * @param Contribution $contribution
     * @return Response
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
     * @return Response
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
     * @return Response
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
