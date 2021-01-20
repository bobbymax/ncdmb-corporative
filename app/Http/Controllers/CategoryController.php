<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $categories = Category::all();

        if ($categories->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'data' => $categories,
            'status' => 'success',
            'message' => 'List of categories'
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
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:categories',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $category = Category::create([
            'name' => $request->name,
            'label' => $request->label,
            'module' => $request->module,
            'description' => $request->description,
            'interest' => isset($request->interest) ? $request->interest : 0,
            'frequency' => isset($request->frequency) ? $request->frequency : 'na',
            'fundable' => isset($request->fundable) ? $request->fundable : false,
            'isLoan' => isset($request->isLoan) ? $request->isLoan : false,
            'restriction' => isset($request->restriction) ? $request->restriction : 0,
            'limit' => isset($request->limit) ? $request->limit : 0,
            'payable' => isset($request->payable) ? $request->payable : 'undefined',
            'committment' => isset($request->committment) ? $request->committment : 0
        ]);

        if (!$category) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Oops!!! Something went terribly wrong!'
            ], 500);
        }

        return response()->json([
            'data' => $category,
            'status' => 'success',
            'message' => 'Category has been created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = Category::where('label', $category)->first();

        if (!$category) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'data' => $category,
            'status' => 'success',
            'message' => 'Data found'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $category = Category::where('label', $category)->first();

        if (!$category) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'data' => $category,
            'status' => 'success',
            'message' => 'Data found'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255|unique:categories',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'data' => $validation->errors(),
                'status' => 'danger',
                'message' => 'Please fix the following errors'
            ], 500);
        }

        $category->update([
            'name' => $request->name,
            'label' => $request->label,
            'module' => $request->module,
            'description' => $request->description,
            'interest' => isset($request->interest) ? $request->interest : 0,
            'frequency' => isset($request->frequency) ? $request->frequency : 'na',
            'fundable' => isset($request->fundable) ? $request->fundable : false,
            'isLoan' => isset($request->isLoan) ? $request->isLoan : false,
            'restriction' => isset($request->restriction) ? $request->restriction : 0,
            'limit' => isset($request->limit) ? $request->limit : 0,
            'payable' => isset($request->payable) ? $request->payable : 'undefined',
            'committment' => isset($request->committment) ? $request->committment : 0
        ]);

        return response()->json([
            'data' => $category,
            'status' => 'success',
            'message' => 'Category has been updated successfully!'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        $category = Category::where('label', $category)->first();

        if (!$category) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Data not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'data' => null,
            'status' => 'success',
            'message' => 'Category deleted successfully.'
        ], 200);
    }
}
