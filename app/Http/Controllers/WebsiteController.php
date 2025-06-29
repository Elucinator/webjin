<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function show(Business $business)
    {
        $theme = $business->theme->name ?? 'default';

        $details = json_decode($business->raw_json, true);

        return view("themes.{$theme}.website", [
            'business' => $business,
            'details' => $details,
        ]);
    }
}
