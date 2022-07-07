<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Rate;


class RateController extends Controller
{
    //

    public function __invoke()
    {
        $base_sybmols = [
            'USD',
            'EUR',
            'GBP',
        ];

        $symbols = [
            'UGX',
            'KES',
            'TZS',
            'RWF'
        ];

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
