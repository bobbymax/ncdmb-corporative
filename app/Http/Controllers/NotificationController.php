<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'users' => 'required|array',
            'message' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the errors!'
            ], 500);
        }

        $url = env('NOTIFICATION_URL') . 'message';

        $response = Http::retry(3, 100)->post($url, [
            'users' => $request->users,
            'body' => $request->message,
        ])->json();

        return $response;
    }
}
