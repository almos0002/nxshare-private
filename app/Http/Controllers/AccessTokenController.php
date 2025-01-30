<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccessTokenController extends Controller
{
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accessType' => [
                'required',
                Rule::in(array_keys(config('access_types')))
            ],
            'postId' => [
                'required',
                'integer',
                Rule::exists(
                    config("access_types.{$request->accessType}.table"),
                    'id'
                )
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $accessType = $request->accessType;
        $postId = $request->postId;
        $ip = $request->ip();

        // Verify 10-second delay
        $accessKey = "access_{$accessType}_{$postId}";
        if (!$request->session()->has($accessKey)) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        if (now()->timestamp - $request->session()->get($accessKey) < 10) {
            return response()->json(['message' => 'Wait 10 seconds'], 403);
        }

        // Check cooldown (1 minute)
        if (AccessToken::where('access_type', $accessType)
            ->where('post_id', $postId)
            ->where('ip_address', $ip)
            ->where('created_at', '>', now()->subMinute())
            ->exists()) {
            return response()->json(['message' => 'Try again later'], 429);
        }

        return response()->json([
            'token' => AccessToken::generateToken($accessType, $postId, $ip)
        ]);
    }
}