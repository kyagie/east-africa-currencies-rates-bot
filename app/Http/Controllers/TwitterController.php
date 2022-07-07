<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwitterController extends Controller
{
    //
    public function index(Request $request)
    {
        // Checks if requests contains crc_token from Twitter servers.
        if ($request->has('crc_token')) {

            $hash = hash_hmac("sha256", $request->crc_token, env("CONSUMER_SECRET"), true);
            return response()->json([
                    "response_token" => "sha256=" . base64_encode($hash)
                ]
            );

        }
    }
    
}
