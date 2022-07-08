<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Rate;
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

    public function tweet(string $message)
    {
        $response = $this->client->post('tweets', [
            'json' => [
                'text' => $message
            ]
        ]);

        return $response->getBody();
    }

    public function postRates()
    {
        $countries = Country::all();
        $rates = Rate::all();

        if (empty($countries) || empty($rates)) {
            # code...
            exit();
        }

        $flags = [
            'Kenya' => '🇰🇪',
            'Uganda' => '🇺🇬',
            'Tanzania' => '🇹🇿',
            'Rwanda' => '🇷🇼'
        ];

        $currency_emojis = [
            'USD' => '💵',
            'EUR' => '💶',
            'GBP' => '💷',
        ];

        foreach ($countries as $country) {
            $tweet = "{$flags[$country->name]} {$country->name}" . "\r\n" . date('D jS F y') . "\r\n\n";
            foreach ($rates as $rate) {
                $r = json_decode($rate->rates, true);
                $tweet .= "{$currency_emojis[$rate->base]}" . " 1 " . $rate->base . "  >>  " . $country->symbol . number_format(round($r[$country->symbol], 2)) . "\r\n";
            }
            $this->tweet($tweet);
        }
    }
}
