<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GooglePlacesService {

    protected $apiKey;

    public function __construct() {
        $this->apiKey = config('services.google_places.key');
    }

    public function searchPlaces($query) {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                    'query' => $query,
                    'key' => $this->apiKey,
        ]);

        return $response->json();
    }

    public function getPlaceDetails($placeId) {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'key' => $this->apiKey,
                    'fields' => 'name,formatted_address,formatted_phone_number,website,opening_hours,geometry,photos,rating'
        ]);

        return $response->json();
    }

}
