<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
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
        $serviceCategories = ServiceCategory::all();

        if ($serviceCategories->count() < 1) {
            return response()->json([
                'data' => null,
                'message' => 'No data found!',
                'status' => 'info'
            ], 200);
        }

        return response()->json([
            'data' => $serviceCategories,
            'message' => 'No data found!',
            'status' => 'success'
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
            'name' => 'required|string|max:255',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'message' => 'Please fix this errors',
                'status' => 'error'
            ], 500);
        }

        $serviceCategory = ServiceCategory::create([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => $serviceCategory,
            'message' => 'Service category created successfully!',
            'status' => 'success'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function show($serviceCategory)
    {
        $serviceCategory = ServiceCategory::find($serviceCategory);

        if (! $serviceCategory) {
            return response()->json([
                'data' => null,
                'message' => 'Invalid token entered',
                'status' => 'error'
            ], 422);
        }

        return response()->json([
            'data' => $serviceCategory,
            'message' => 'Service category details',
            'status' => 'success'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($serviceCategory)
    {
        $serviceCategory = ServiceCategory::find($serviceCategory);

        if (! $serviceCategory) {
            return response()->json([
                'data' => null,
                'message' => 'Invalid token entered',
                'status' => 'error'
            ], 422);
        }

        return response()->json([
            'data' => $serviceCategory,
            'message' => 'Service category details',
            'status' => 'success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviceCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'message' => 'Please fix this errors',
                'status' => 'error'
            ], 500);
        }

        $serviceCategory = ServiceCategory::find($serviceCategory);

        if (! $serviceCategory) {
            return response()->json([
                'data' => null,
                'message' => 'Invalid token entered',
                'status' => 'error'
            ], 422);
        }

        $serviceCategory->update([
            'name' => $request->name,
            'label' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => $serviceCategory,
            'message' => 'Service category updated successfully!',
            'status' => 'success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviceCategory)
    {
        $serviceCategory = ServiceCategory::find($serviceCategory);

        if (! $serviceCategory) {
            return response()->json([
                'data' => null,
                'message' => 'Invalid token entered',
                'status' => 'error'
            ], 422);
        }

        $serviceCategory->delete();

        return response()->json([
            'data' => null,
            'message' => 'Service category deleted successfully!',
            'status' => 'success'
        ], 200);
    }
}
