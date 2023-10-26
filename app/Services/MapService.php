<?php

namespace App\Services;

class MapService{

    public function getGeoLocationFromGoogleMaps($address) {

        $url = 'https://www.google.com/maps/dir/' . urlencode($address);
        dd($url);

        // Inicializáljuk a cURL sessiont
        $ch = curl_init();

        // Beállítjuk a cURL opciókat
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);  // Fejlécet is visszaadjuk

        // Végrehajtjuk a cURL kérést
        $output = curl_exec($ch);

        dd($output);

        // Bontsuk le az átirányított URL-t
        $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        // Bezárjuk a cURL sessiont
        curl_close($ch);

        // Regex kifejezéssel keresünk geolokációs adatokat az átirányított URL-ben
        $pattern = '/@(-?\d+\.\d+),(-?\d+\.\d+),\d+z/';
        if (preg_match($pattern, $redirectedUrl, $matches)) {
            return [
                'lat' => $matches[1],
                'lon' => $matches[2]
            ];
        } else {
            return null;
        }
    }



public function test(){
    $address = 'VITKOVICS MIHÁLY UTCA 8., BUDAPEST';
    $result = $this->getGeoLocationFromGoogleMaps($address);
    if ($result) {
        echo "Latitude: " . $result['lat'] . ", Longitude: " . $result['lon'];
    } else {
        echo "Nem található geolokációs adat.";
    }
    }
}
