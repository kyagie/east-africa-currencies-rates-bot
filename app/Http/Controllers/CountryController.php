<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //

    public function index()
    {
        $countries = [
            'Kenya',
            'Rwanda',
            'Tanzania',
            'Uganda',
        ];

        $currencies = [
            'Kenya' => 'Kenyan Shilling',
            'Rwanda' => 'Rwanda Franc',
            'Tanzania' => 'Tanzanian Shilling',
            'Uganda' => 'Ugandan Shilling',
        ];

        $symbols = [
            'Kenya' => 'KES',
            'Rwanda' => 'RWF',
            'Tanzania' => 'TZS',
            'Uganda' => 'UGX',
        ];

        foreach($countries as $c) {
            $country = new Country();
            $country->name = $c;
            $country->currency = $currencies[$c];
            $country->symbol = $symbols[$c];
            $country->save();
        }

    }
}
