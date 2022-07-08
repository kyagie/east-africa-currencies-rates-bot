<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterController extends Controller
{
    //
    private $endpoint = 'https://api.twitter.com/2/';

    protected $client;

    public function __construct()
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => env('CONSUMER_KEY'),
            'consumer_secret' => env('CONSUMER_SECRET'),
            'token'           => env('ACCESS_TOKEN'),
            'token_secret'    => env('ACCESS_TOKEN_SECRET'),
        ]);
        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }

    public function index(Request $request)
    {
        // Checks if requests contains crc_token from Twitter servers.
        if ($request->has('crc_token')) {

            $hash = hash_hmac("sha256", $request->crc_token, env('CONSUMER_SECRET'), true);
            return response()->json(
                [
                    "response_token" => "sha256=" . base64_encode($hash)
                ]
            );
        }

        return response('Ok.', 200);
    }

    public function tweet(string $message)
    {
        $response = $this->client->post('tweets', [
            'json' => [
                'text' => $message
            ]
        ]);

        return $response->getBody();
    }
}
