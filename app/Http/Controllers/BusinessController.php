<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\GooglePlacesService;
use App\Models\Theme;

class BusinessController extends Controller {

    public function generatorView() {
        $themes = Theme::where('is_active', true)->get();
        return view('business.generator', [
            'themes' => $themes
        ]);
    }

    public function search(Request $request, GooglePlacesService $places) {
        $results = $places->searchPlaces($request->query('q'));
        return response()->json($results);
    }

    public function details(Request $request, GooglePlacesService $places) {
        $details = $places->getPlaceDetails($request->query('place_id'));
        return response()->json($details);
    }

    public function generate(Request $request) {
        $data = json_decode($request->input('business_json'), true);
        $placeId = $request->input('place_id');

        $photoReference = $data['photos'][0]['photo_reference'] ?? null;
        $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photoReference}&key=YOUR_API_KEY";

        $photoUrl = $photoReference ? "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photoReference}&key=" . config('services.google_places.key') : null;

        $lat = $data['geometry']['location']['lat'] ?? null;
        $lng = $data['geometry']['location']['lng'] ?? null;

        $theme = Theme::where('name', $request->input('theme_name'))->first();

        $business = Business::updateOrCreate(
                        ['place_id' => $placeId],
                        [
                            'name' => $data['name'] ?? '',
                            'address' => $data['formatted_address'] ?? '',
                            'phone' => $data['formatted_phone_number'] ?? '',
                            'website' => $data['website'] ?? '',
                            'photo_url' => $photoUrl,
                            'lat' => $lat,
                            'lng' => $lng,
                            'raw_json' => json_encode($data),
                            'theme_id' => $theme?->id,
                        ]
        );

        $slug = Str::slug($business->name) . '-' . $business->id;

        return response()->json([
                    'url' => route('business.site.view', ['slug' => $slug]),
        ]);
    }

    public function viewSite($slug) {
        $id = last(explode('-', $slug));
        $business = Business::findOrFail($id);
        $details = json_decode($business->raw_json, true);
        $theme = $business->theme->name ?? 'default';

        return view("themes.$theme.website", [
            'business' => $business,
            'details' => $details,
        ]);
    }

    public function changeTheme(Request $request, Business $business)
    {
        $request->validate([
            'theme_name' => 'required|exists:themes,name',
        ]);

        $theme = Theme::where('name', $request->input('theme_name'))->firstOrFail();

        $business->theme()->associate($theme);
        $business->save();

        return redirect()
            ->back()
            ->with('success', 'Theme updated successfully!');

    }


}
