<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwitterController extends Controller
{
    //
    public function index(Request $request)
    {
        Log::info("twitter-logs", [
            $request
        ]);

        // Checks if requests contains crc_token from Twitter servers.
        if ($request->has('crc_token')) {

            $hash = hash_hmac("sha256", $request->crc_token, env("CONSUMER_SECRET"), true);
            return response()->json(
                [
                    "response_token" => "sha256=" . base64_encode($hash)
                ]
            );
        }

        return response('Ok.', 200);

    }
}
