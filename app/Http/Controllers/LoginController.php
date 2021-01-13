<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // test change
        $loginRules = [
            'staff_no' => 'required|string|max:255',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $loginRules);

        // check if validation rules failed
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'errors' => $validator->errors()
                ],
                'message' => 'An error occured',
                'status' => 'danger',
            ], 422);
        }

        $loginCredentials = $request->only('staff_no', 'password');
        
        if (!Auth::attempt($loginCredentials)) {
            return response()->json([
                'data' => null,
                'message' => 'Invalid login details',
                'status' => 'danger',
            ], 422);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json(
            [
                'message' => 'Login Successful',
                'data' => [
                    'token' => $token,
                    'member' => new UserResource(Auth::user()),
                ]
            ]
        );
    }
}
