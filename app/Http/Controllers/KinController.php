<?php

namespace App\Http\Controllers;

use App\Models\Kin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kin = Kin::all();
        if ($kin->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }

        return response()->json([
            'data' => $kin,
            'status' => 'success',
            'message' => 'Members next of kin List!'
        ], 404);
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
        // $validation = Validator::make($request->all(), [
        //     'name' => 
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kin  $kin
     * @return \Illuminate\Http\Response
     */
    public function show($kin)
    {
        $kin = Kin::find($kin);

        if (! $kin) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'data' => $kin,
            'status' => 'success',
            'message' => 'Kin data found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kin  $kin
     * @return \Illuminate\Http\Response
     */
    public function edit(Kin $kin)
    {
        $kin = Kin::find($kin);

        if (! $kin) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'data' => $kin,
            'status' => 'success',
            'message' => 'Kin data found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kin  $kin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kin)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'phone' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors:'
            ], 500);
        }

        $kin = Kin::find($kin);

        if (! $kin) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'Data not found',
            ], 404);
        }

        $kin->update([
            'name' => $request->name,
            'relationship' => $request->relationship,
            'mobile' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'data' => $kin,
            'status' => 'success',
            'message' => 'Kin data updated successfully!!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kin  $kin
     * @return \Illuminate\Http\Response
     */
    public function destroy($kin)
    {
        $kin = Kin::find($kin);

        if (! $kin) {
            return response()->json([
                'data' => null,
                'status' => 'danger',
                'message' => 'Data not found',
            ], 404);
        }

        $kin->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Kin data deleted successfully!!'
        ], 200);
    }
}
