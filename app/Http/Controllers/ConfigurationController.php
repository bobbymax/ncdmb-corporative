<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;
use App\Http\Resources\SettingResource;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix the following error(s):'
            ], 500);
        }


        $settings = Setting::latest()->get();


        foreach ($settings as $key => $setting) {
            if (isset($request->state[$setting->key])) {
                $setting->value = $request->state[$setting->key];
                $setting->save();
            }
        }

        return response()->json([
            'data' => SettingResource::collection($settings),
            'status' => 'success',
            'message' => 'Settings value updated successfully!'
        ], 201);
    }
}
