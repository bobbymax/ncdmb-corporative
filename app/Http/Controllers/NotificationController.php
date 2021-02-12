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

    public static function messageAfterLoanRequest($phone, $amount)
    {

        $message = "Hello, " . auth()->user()->firstname . " " . auth()->user()->surname . " you've requested a loan of ₦" . number_format($amount) . " from the NCDMB";

        self::message($phone, $message);
    }

    public static function messageAfterLoanRegistered($phone, $loan)
    {

        $message = "Hello, " . $loan->member->firstname . " " . $loan->member->surname . " your loan of " . $loan->code . " for the purpose of " . $loan->reason . " has been registered";

        self::message($phone, $message);
    }

    public static function message($phone, $message)
    {
        $url = env('NOTIFICATION_URL') . 'message';
        $data = [
            'users' => $phone,
            'body' => $message,
        ];

        $response = Http::retry(3, 100)->post($url, $data)->json();
    }
}
