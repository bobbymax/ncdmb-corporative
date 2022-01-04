<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $companies = Company::latest()->get();

        if ($companies->count() < 1) {
            return response()->json([
                'data' => [],
                'status' => 'info',
                'message' => 'No data found'
            ], 204);
        }

        return response()->json([
            'data' => $companies,
            'status' => 'success',
            'message' => 'Company List'
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
            'registration_no' => 'required|string|max:255|unique:companies',
            'reference_no' => 'required|max:255|unique:companies',
            'tin_no' => 'required|string|max:255|unique:companies',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:companies',
            'mobile' => 'required|string|unique:companies',
            'type' => 'required|string|in:vendor,owner',
            'category' => 'required|string|in:nigeria-owned,nigeria-company-owned-by-foreign-company,foreign-owned,government-owned'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following error(s):'
            ], 500);
        }

        $company = Company::create([
            'registration_no' => $request->registration_no,
            'tin_no' => $request->tin_no,
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'email' => $request->email,
            'mobile' => $request->mobile,
            'type' => $request->type,
            'reference_no' => $request->reference_no,
            'category' => $request->category
        ]);

        return response()->json([
            'data' => $company,
            'status' => 'success',
            'message' => 'Company Created Successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($company)
    {
        $company = Company::find($company);

        if (! $company) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token'
            ], 422);
        }

        return response()->json([
            'data' => $company,
            'status' => 'success',
            'message' => 'Company Details'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company = Company::find($company);

        if (! $company) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token'
            ], 422);
        }

        return response()->json([
            'data' => $company,
            'status' => 'success',
            'message' => 'Company Details'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $company)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following error(s):'
            ], 500);
        }

        $company = Company::find($company);

        if (! $company) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token'
            ], 422);
        }

        $company->update([
            'mobile' => $request->mobile,
        ]);

        return response()->json([
            'data' => $company,
            'status' => 'success',
            'message' => 'Vendor updated Successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($company)
    {
        $company = Company::find($company);

        if (! $company) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token'
            ], 422);
        }

        $old = $company;
        $company->delete();

        return response()->json([
            'data' => $old,
            'status' => 'success',
            'message' => 'Vendor record deleted Successfully!'
        ], 200);
    }
}
