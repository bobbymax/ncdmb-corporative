<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WalletController extends Controller
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
        $wallets = Wallet::all();
        if ($wallets->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }

        return response()->json([
            'data' => $wallets,
            'status' => 'success',
            'message' => 'Data was found!'
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show($wallet)
    {
        $wallet = Wallet::where('identifier', $wallet)->first();
        if (! $wallet) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $wallet,
            'status' => 'success',
            'message' => 'Data was found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit($wallet)
    {
        $wallet = Wallet::where('identifier', $wallet)->first();
        if (! $wallet) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => $wallet,
            'status' => 'success',
            'message' => 'Data was found!'
        ], 200);
    }

    public function updateMemberWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member' => 'required',
            'balance' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $member = User::where('staff_no', $request->member)->first();

        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid user token'
            ], 422);
        }

        $member->wallet->current = $request->balance;
        $member->wallet->save();

        return response()->json([
            'data' => new UserResource($member),
            'status' => 'success',
            'message' => 'Member wallet updated successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $wallet)
    {
        $validation = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:15',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $wallet = Wallet::where('identifier', $wallet)->first();
        if (! $wallet) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'No data was found!'
            ], 404);
        }

        $wallet->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number
        ]);

        return response()->json([
            'data' => $wallet,
            'status' => 'success',
            'message' => 'Data was updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
