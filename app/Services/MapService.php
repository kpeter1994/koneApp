<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class MapService{

    public function getGeoLocation($address){

        //$apiKey = '4dc51cca94e940118ab737aaba329121';
        $apiKey = 'c4c532f01d4448e896548c0fade0f24c';

        $response = Http::get('https://api.geoapify.com/v1/geocode/search', [
            'text' => $address,
            'format' => 'json',
            'apiKey' => $apiKey
            ]);

        return $response->json();
    }



    public function test()
    {
        $equipments = \App\Models\Equipment::all();

        foreach ($equipments as $equipment) {
            $geoLocation = $this->getGeoLocation($equipment->address);
            $equipment->lat = $geoLocation['results'][0]['lat'];
            $equipment->lng = $geoLocation['results'][0]['lon'];
            $equipment->save();
        }
//        dd($this->getGeoLocation('HORVÁTH MIHÁLY TÉR 15., BUDAPEST')['results'][0]['lon']);

    }

}
