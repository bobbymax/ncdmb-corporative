<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
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
        $chartOfAccounts = ChartOfAccount::latest()->get();

        if ($chartOfAccounts->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found!!'
            ], 204);
        }

        return response()->json([
            'data' => $chartOfAccounts,
            'status' => 'success',
            'message' => 'Account Codes List'
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
            'account_code_id' => 'required|integer',
            'code' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $chartOfAccount = ChartOfAccount::create([
            'account_code_id' => $request->account_code_id,
            'name' => $request->name,
            'code' => $request->code,
            'label' => Str::slug($request->name)
        ]);

        return response()->json([
            'data' => $chartOfAccount,
            'status' => 'success',
            'message' => 'New Chart of Account created!!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function show($chartOfAccount)
    {
        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        return response()->json([
            'data' => $chartOfAccount,
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($chartOfAccount)
    {
        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        return response()->json([
            'data' => $chartOfAccount,
            'status' => 'success',
            'message' => 'Account Code Details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chartOfAccount)
    {
        $validator = Validator::make($request->all(), [
            'account_code_id' => 'required|integer',
            'code' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Please fix the following errors!'
            ], 500);
        }

        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        $chartOfAccount->update([
            'account_code_id' => $request->account_code_id,
            'name' => $request->name,
            'code' => $request->code,
            'label' => Str::slug($request->name)
        ]);

        return response()->json([
            'data' => $chartOfAccount,
            'status' => 'success',
            'message' => 'New Chart of Account updated!!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChartOfAccount  $chartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($chartOfAccount)
    {
        $chartOfAccount = ChartOfAccount::find($chartOfAccount);

        if (! $chartOfAccount) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token entered'
            ], 422);
        }

        $old = $chartOfAccount;

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Chart of Account deleted successfully!!'
        ], 200);
    }
}
