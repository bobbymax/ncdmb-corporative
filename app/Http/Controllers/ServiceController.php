<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceController extends Controller
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
        $services = Service::latest()->get();
        if ($services->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!'
            ], 404);
        }
        return response()->json([
            'data' => $services,
            'status' => 'success',
            'message' => $services->count() . ' data found!'
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
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:services',
            'description' => 'required|min:5',
            'category_id' => 'required|integer',
            'method' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $service = Service::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'label' => $request->label,
            'method' => $request->method,
            'description' => $request->description
        ]);

        return response()->json([
            'data' => $service,
            'status' => 'success',
            'message' => 'Service request created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($service)
    {
        $service = Service::where('label', $service)->first();
        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 404);
        }

        return response()->json([
            'data' => $service,
            'status' => 'success',
            'message' => 'Data entry found!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($service)
    {
        $service = Service::where('label', $service)->first();
        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 404);
        }

        return response()->json([
            'data' => $service,
            'status' => 'success',
            'message' => 'Data entry found!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $service)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:services',
            'description' => 'required|min:5',
            'category_id' => 'required|integer',
            'method' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $service = Service::where('label', $service)->first();
        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 404);
        }

        $service->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'label' => $request->label,
            'method' => $request->method,
            'description' => $request->description
        ]);

        return response()->json([
            'data' => $service,
            'status' => 'success',
            'message' => 'Service request updated successfully!'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($service)
    {
        $service = Service::where('label', $service)->first();
        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 404);
        }
        $service->delete();
        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data entry deleted successfully!'
        ], 200);
    }
}
