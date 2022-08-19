<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\OnboardMembersJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MailingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function onBoardMembers()
    {
        $members = User::latest()->get();

        $users = $members->filter(function ($member) {
            return $member->isAdministrator != 1;
        });

        foreach ($users as $user) {
            if ($user->email !== "") {
                dispatch(new OnboardMembersJob($user));
            }
        }

        return response()->json([
            'data' => $users,
            'status' => 'success',
            'message' => 'Mail Sent'
        ], 200);
    }

    public function resetMemberPassword(Request $request, $member)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'oldPassword' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the error!'
            ], 500);
        }

        $member = User::find($request->user_id);

        if (! $member) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'Invalid token entered'
            ], 422);
        }

        if (! Hash::check($request->oldPassword, $member->password)) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'Current Password Mismatch!!'
            ], 422);
        }

        $member->password = Hash::make($request->password);
        $member->save();


        return response()->json([
            'data' => $member,
            'status' => 'success',
            'message' => 'Password has been updated successfully!!'
        ], 200);
    }
}
