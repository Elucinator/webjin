<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $business->name }}
        </h2>
    </x-slot>

    <div class="py-10 px-6 max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            {{-- Cover Photo --}}
            @if($business->photo_url)
            <img src="{{ $business->photo_url }}" alt="{{ $business->name }} Photo" class="w-full h-64 object-cover">
            @endif

            <div class="p-6 space-y-6">
                {{-- Basic Info --}}
                <div class="space-y-2">
                    <p class="text-lg"><strong>Address:</strong> {{ $business->address }}</p>
                    <p class="text-lg"><strong>Phone:</strong> {{ $business->phone ?? 'N/A' }}</p>
                    <p class="text-lg"><strong>Website:</strong> 
                        @if($business->website)
                        <a href="{{ $business->website }}" target="_blank" class="text-blue-600 underline">
                            {{ $business->website }}
                        </a>
                        @else
                        N/A
                        @endif
                    </p>
                    <p class="text-lg"><strong>Rating:</strong> {{ $details['rating'] ?? 'N/A' }} ⭐</p>
                    <p class="text-lg"><strong>User Ratings Count:</strong> {{ $details['user_ratings_total'] ?? 'N/A' }}</p>
                </div>

                {{-- Opening Hours --}}
                @if(isset($details['opening_hours']['weekday_text']))
                <div class="mt-4">
                    <h3 class="text-xl font-bold mb-2">Opening Hours</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach($details['opening_hours']['weekday_text'] as $day)
                        <li>{{ $day }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Reviews --}}
                @if(isset($details['reviews']) && count($details['reviews']))
                <div class="mt-4">
                    <h3 class="text-xl font-bold mb-2">Reviews</h3>
                    @foreach(array_slice($details['reviews'], 0, 3) as $review)
                    <div class="border rounded p-3 mb-3">
                        <p class="text-sm font-semibold">{{ $review['author_name'] }} – {{ $review['rating'] }}⭐</p>
                        <p class="text-gray-700 text-sm">{{ $review['text'] }}</p>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Embedded Google Map --}}
                @if($business->lat && $business->lng)
                <div class="mt-6">
                    <iframe
                        width="100%"
                        height="300"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google_places.key') }}&q={{ $business->lat }},{{ $business->lng }}">
                    </iframe>
                </div>
                @endif

                {{-- Google Maps Button --}}
                @if(isset($details['url']))
                <div class="mt-6 text-center">
                    <a href="{{ $details['url'] }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        View on Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
