<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReceiveResource;
use App\Models\Receive;
use Illuminate\Http\Request;

class ReceiveController extends Controller
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
        $receiveables = Receive::all();

        if ($receiveables->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data found!!'
            ], 404);
        }

        return response()->json([
            'data' => ReceiveResource::collection($receiveables),
            'status' => 'success',
            'message' => 'Receiveables List'
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
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($receive)
    {
        $receive = Receive::where('identifier', $receive)->first();

        if (! $receive) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        }

        return response()->json([
            'data' => new ReceiveResource($receive),
            'status' => 'error',
            'message' => 'Invalid token'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($receive)
    {
        $receive = Receive::where('identifier', $receive)->first();

        if (! $receive) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        }

        return response()->json([
            'data' => new ReceiveResource($receive),
            'status' => 'error',
            'message' => 'Invalid token'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receive $receive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receive $receive)
    {
        //
    }
}
