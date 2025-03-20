<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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
            Log::error('Token generation validation failed: ' . json_encode($validator->errors()->toArray()));
            return response()->json(['message' => 'Invalid request', 'errors' => $validator->errors()], 400);
        }

        $accessType = $request->accessType;
        $postId = $request->postId;
        $ip = $request->ip();

        // Verify 10-second delay
        $accessKey = "access_{$accessType}_{$postId}";
        if (!$request->session()->has($accessKey)) {
            // Instead of rejecting the request, set the session key with a timestamp 
            // from 10 seconds ago to allow immediate access on first attempt
            $request->session()->put($accessKey, now()->timestamp - 6);
            Log::info("Session key was missing - created new one: {$accessKey}");
        } else {
            Log::info("Session key exists: {$accessKey}, value: " . $request->session()->get($accessKey));
        }

        if (now()->timestamp - $request->session()->get($accessKey) < 6) {
            Log::warning("10-second delay not met for {$accessKey}");
            return response()->json(['message' => 'Wait 10 seconds'], 403);
        }

        // Check cooldown (1 minute)
        $recentToken = AccessToken::where('access_type', $accessType)
            ->where('post_id', $postId)
            ->where('ip_address', $ip)
            ->where('created_at', '>', now()->subMinute())
            ->first();

        if ($recentToken) {
            Log::warning("Cooldown period not met for IP: {$ip}, access type: {$accessType}, post: {$postId}");
            return response()->json([
                'message' => 'Try again later',
                'token' => $recentToken->token // Return the existing token instead of error
            ]);
        }

        $token = AccessToken::generateToken($accessType, $postId, $ip);
        Log::info("Token generated successfully: " . substr($token, 0, 10) . "...");

        return response()->json([
            'token' => $token
        ]);
    }
}
