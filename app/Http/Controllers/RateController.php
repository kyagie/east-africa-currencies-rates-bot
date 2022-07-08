<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use App\Models\Rate;


class RateController extends Controller
{
    //
    public $countries;

    public function __construct(Country $countries)
    {
        $this->countries = $countries;
    }

    public function index()
    {
        Rate::truncate();

        $base_sybmols = [
            'USD',
            'EUR',
            'GBP',
        ];

        $symbols = $this->countries->pluck('symbol')->toArray();

        foreach ($base_sybmols as $base_symbol) {
            $response = Http::withHeaders([
                "apiKey" => env('EXCHANGE_API_KEY'),
            ])
                ->retry(
                    3,
                    100
                )->get('https://api.apilayer.com/exchangerates_data/latest?symbols=' . implode(",", $symbols) .  '&base=' . $base_symbol);

            $rates = $response->json()['rates'];

            Rate::create([
                'base' => $base_symbol,
                'rates' => json_encode($rates),
            ]);
        }

        
    }
}
