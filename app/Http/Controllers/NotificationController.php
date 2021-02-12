<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public static function message($phone)
    {
        // $validator = Validator::make($request->all(), [
        //     'users' => 'required|array',
        //     'message' => 'required|string|max:255'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'data' => $validator->errors(),
        //         'status' => 'error',
        //         'message' => 'Please fix the errors!'
        //     ], 500);
        // }

        $message = "Hello, " . auth()->user()->firstname . " " . auth()->user()->lastname . " you've requested a loan of ₦" . number_format($request->amount) . " from the NCDMB";
        NotificationController::message(["+234" . auth()->user()->mobile], $message);

        $url = env('NOTIFICATION_URL') . 'message';
        $data = [
            'users' => $phone,
            'body' => $message,
        ];

        $response = Http::retry(3, 100)->post($url, $data)->json();
    }
}
