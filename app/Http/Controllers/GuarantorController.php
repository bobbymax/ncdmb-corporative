<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GuarantorController extends Controller
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
        $guarantors = Guarantor::all();
        if ($guarantors->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found'
            ], 404);
        }
        return response()->json([
            'data' => $guarantors,
            'status' => 'success',
            'message' => 'Data was found'
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
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function show($guarantor)
    {
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found'
            ], 404);
        }
        return response()->json([
            'data' => $guarantor,
            'status' => 'success',
            'message' => 'Data was found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function edit(Guarantor $guarantor)
    {
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found'
            ], 404);
        }
        return response()->json([
            'data' => $guarantor,
            'status' => 'success',
            'message' => 'Data was found'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $guarantor)
    {
        $validation = Validator::make($request->all(), [
            'remark' => 'required|min:3',
            'status' => 'required|string|max:255'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Fix the following errors'
            ], 500);
        }
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found'
            ], 404);
        }
        $guarantor->update([
            'remark' => $request->remark,
            'status' => $request->status
        ]);
        return response()->json([
            'data' => $guarantor,
            'status' => 'success',
            'message' => 'Data was updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guarantor  $guarantor
     * @return \Illuminate\Http\Response
     */
    public function destroy($guarantor)
    {
        $guarantor = Guarantor::find($guarantor);
        if (! $guarantor) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'No data was found'
            ], 404);
        }
        $guarantor->delete();
        return response()->json([
            'data' => $guarantor,
            'status' => 'success',
            'message' => 'Data was deleted successfully!'
        ], 200);
    }
}
