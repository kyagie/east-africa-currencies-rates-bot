<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Spatie\SlackAlerts\Facades\SlackAlert;

class CountryController extends Controller
{
    //

    public function index()
    {
        Country::truncate();

        $countries = [
            'Kenya',
            'Rwanda',
            'Tanzania',
            'Uganda',
            'South Sudan',
            'DRC',
        ];

        $currencies = [
            'Kenya' => 'Kenyan Shilling',
            'Rwanda' => 'Rwanda Franc',
            'Tanzania' => 'Tanzanian Shilling',
            'Uganda' => 'Ugandan Shilling',
            'South Sudan' => 'Sudanese Pound',
            'DRC' => 'Congolese Franc',
        ];

        $symbols = [
            'Kenya' => 'KES',
            'Rwanda' => 'RWF',
            'Tanzania' => 'TZS',
            'Uganda' => 'UGX',
            'South Sudan' => 'SDG',
            'DRC' => 'CDF',
        ];

        foreach($countries as $c) {
            $country = new Country();
            $country->name = $c;
            $country->currency = $currencies[$c];
            $country->symbol = $symbols[$c];
            $country->save();
        }
        SlackAlert::message("*Countries Added* at " . date('H:i:s'));

    }
}
