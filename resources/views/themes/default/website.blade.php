<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $business->name }} (Default Theme)
        </h2>
    </x-slot>

    <div class="py-10 px-6 max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden">

            @if($business->photo_url)
            <img src="{{ $business->photo_url }}" alt="{{ $business->name }} Photo" class="w-full h-64 object-cover">
            @endif

            <div class="p-6 space-y-6 text-gray-800">
                <div>
                    <p><strong>Address:</strong> {{ $business->address }}</p>
                    <p><strong>Phone:</strong> {{ $business->phone ?? 'N/A' }}</p>
                    <p><strong>Website:</strong>
                        @if($business->website)
                        <a href="{{ $business->website }}" target="_blank" class="text-blue-600 underline">
                            {{ $business->website }}
                        </a>
                        @else N/A @endif
                    </p>
                    <p><strong>Rating:</strong> {{ $details['rating'] ?? 'N/A' }} ⭐</p>
                    <p><strong>User Ratings Count:</strong> {{ $details['user_ratings_total'] ?? 'N/A' }}</p>
                </div>

                @if(isset($details['opening_hours']['weekday_text']))
                <div>
                    <h3 class="font-bold text-lg mb-2">Opening Hours</h3>
                    <ul class="list-disc list-inside">
                        @foreach($details['opening_hours']['weekday_text'] as $day)
                        <li>{{ $day }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(isset($details['reviews']))
                <div>
                    <h3 class="font-bold text-lg mb-2">Top Reviews</h3>
                    @foreach(array_slice($details['reviews'], 0, 3) as $review)
                    <div class="border rounded p-3 mb-3 bg-gray-100">
                        <p class="text-sm font-semibold">{{ $review['author_name'] }} – {{ $review['rating'] }}⭐</p>
                        <p class="text-sm text-gray-700">{{ $review['text'] }}</p>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($business->lat && $business->lng)
                <div>
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

                @if(isset($details['url']))
                <div class="text-center">
                    <a href="{{ $details['url'] }}" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        View on Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
