<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Spatie\SlackAlerts\Facades\SlackAlert;

class CountryController extends Controller
{
    //

    public function index()
    {
        Country::trucate();
        
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
            'South Sudan' => 'South Sudanese Pound',
            'DRC' => 'Congolese Franc',
        ];

        $symbols = [
            'Kenya' => 'KES',
            'Rwanda' => 'RWF',
            'Tanzania' => 'TZS',
            'Uganda' => 'UGX',
            'South Sudan' => 'SSP',
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
