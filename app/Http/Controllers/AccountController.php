<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class AccountController extends Controller
{

    protected $holder, $datasends;

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
        $accounts = Account::all();

        if ($accounts->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found!!'
            ], 404);
        }

        return response()->json([
            'data' => $accounts,
            'status' => 'success',
            'message' => 'Account List'
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
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|unique:accounts',
            'account_name' => 'required|string|max:255',
            'entity' => 'required|string|in:staff,organization,vendor',
            'holder' => 'required|string|in:staff,vendor',
            'holder_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $this->holder = $this->getHolder($request->holder, $request->holder_id);

        if (! $this->holder) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid holder ID'
            ], 422);
        }

        $account = new Account;

        $account->bank = $request->bank;
        $account->account_number = $request->account_number;
        $account->account_name = $request->account_name;
        $account->entity = $request->entity;
        $this->holder->accounts()->save($account);

        // $this->datasends = $request->holder == "staff" ? new UserResource($this->holder) : null;

        $data = isset($request->url) && $request->url === "profile-update" ? new UserResource($this->holder) : $account;

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Account has been created successfully!!'
        ], 201);
    }

    private function getHolder($str, $id)
    {
        switch ($str) {
            case 'vendor':
                return Company::find($id);
                break;

            default:
                return User::find($id);
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($account)
    {
        $account = Account::find($account);
        if (! $account) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID entered'
            ], 422);
        }
        return response()->json([
            'data' => $account,
            'status' => 'success',
            'message' => 'Account details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($account)
    {
        $account = Account::find($account);
        if (! $account) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID entered'
            ], 422);
        }
        return response()->json([
            'data' => $account,
            'status' => 'success',
            'message' => 'Account details'
        ], 200);
    }

    public function makePrimary(Request $request, $account)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'primary' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $account = Account::find($account);
        $user = User::find($request->user_id);

        if (! ($account && $user)) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID entered'
            ], 422);
        }

        $previous = $user->accounts->where('primary', true)->first();

        if ($previous && $previous->id != $account->id) {
            $previous->primary = false;
            $previous->save();
        }

        $account->update([
            'primary' => $request->primary,
        ]);

        return response()->json([
            'data' => new UserResource($user),
            'status' => 'success',
            'message' => 'Account has been made primary'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $account)
    {
        $validator = Validator::make($request->all(), [
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'entity' => 'required|string|in:staff,organization,vendor'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $account = Account::find($account);

        if (! $account) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID entered'
            ], 422);
        }

        $account->update([
            'bank' => $request->bank,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'entity' => $request->entity
        ]);

        return response()->json([
            'data' => $account,
            'status' => 'success',
            'message' => 'Account details'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($account)
    {
        $account = Account::find($account);
        if (! $account) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid ID entered'
            ], 422);
        }

        $old = $account;
        $account->delete();

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Account details'
        ], 200);
    }
}
