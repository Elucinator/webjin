<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Services\GooglePlacesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Theme;

class WebsiteController extends Controller
{
    public function index()
    {
        $businesses = Business::with('theme')->latest()->paginate(10);

        return view('dashboard.websites.index', compact('businesses'));
    }



    public function regenerate(Business $business, Request $request, GooglePlacesService $places)
    {
        $request->validate([
            'theme_name' => 'required|exists:themes,name',
        ]);

        $theme = Theme::where('name', $request->input('theme_name'))->first();

        $details = $places->getPlaceDetails($business->place_id);

        if (!$details || isset($details['error_message'])) {
            return redirect()->back()->with('error', 'Failed to fetch data from Google Places API.');
        }

        $photoRef = $details['photos'][0]['photo_reference'] ?? null;
        $photoUrl = $photoRef
            ? "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photoRef}&key=" . config('services.google_places.key')
            : $business->photo_url;

        $business->update([
            'name' => $details['name'] ?? $business->name,
            'address' => $details['formatted_address'] ?? $business->address,
            'phone' => $details['formatted_phone_number'] ?? $business->phone,
            'website' => $details['website'] ?? $business->website,
            'photo_url' => $photoUrl,
            'lat' => $details['geometry']['location']['lat'] ?? $business->lat,
            'lng' => $details['geometry']['location']['lng'] ?? $business->lng,
            'raw_json' => json_encode($details),
        ]);

        // Associate theme
        $business->theme()->associate($theme);
        $business->save();

        return redirect()->route('dashboard.websites')->with('success', 'Website regenerated successfully with new theme.');
    }


    public function showRegenerationForm(Business $business)
    {
        $themes = Theme::all();

        return view('dashboard.websites.regenerate', compact('business', 'themes'));
    }


}
