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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'description' => 'required|min:5',
            'category' => 'required|string',
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
            'category' => $request->category,
            'serviceCode' => time(),
            'request_date' => Carbon::parse($request->request_date),
            'payment_method' => $request->payment_method,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($service)
    {
        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($service)
    {
        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $service)
    {
        $validation = Validator::make($request->all(), [
            'description' => 'required|min:5',
            'category' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'error',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        $service->update([
            'category' => $request->category,
            'request_date' => Carbon::parse($request->request_date),
            'payment_method' => $request->payment_method,
            'description' => $request->description
        ]);

        return response()->json([
            'data' => $service,
            'status' => 'success',
            'message' => 'Service request updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($service)
    {
        $service = Service::find($service);

        if (! $service) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Data entry is invalid!'
            ], 422);
        }

        $service->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Data entry deleted successfully!'
        ], 200);
    }
}
