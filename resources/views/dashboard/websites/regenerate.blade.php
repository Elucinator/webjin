<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            Regenerate Website – {{ $business->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- ✅ Flash Message --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-800 px-4 py-2 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- 🎨 Theme Selection (Change Theme Only) --}}
        <form method="POST" action="{{ route('dashboard.websites.changeTheme', $business->id) }}" class="mb-10">
            @csrf

            <h3 class="text-lg font-semibold mb-4">Choose a Theme</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($themes as $theme)
                    <label class="relative block cursor-pointer rounded-xl overflow-hidden shadow-sm transition duration-200">
                        {{-- Radio Input --}}
                        <input type="radio" name="theme_name" value="{{ $theme->name }}"
                               {{ $business->theme?->name === $theme->name ? 'checked' : '' }}
                               class="peer sr-only" />

                        {{-- Card UI --}}
                        <div class="border rounded-xl ring-1 ring-gray-300 peer-checked:ring-2 peer-checked:ring-blue-500 hover:ring-blue-300">
                            <img src="{{ asset($theme->preview_image) }}" alt="{{ $theme->label }}"
                                 class="w-full h-40 object-cover transition duration-300 peer-hover:scale-105" />

                            <div class="p-3 text-center space-y-1">
                                <p class="font-medium text-gray-800">{{ $theme->label }}</p>
                                <a href="{{ route('theme.preview', ['theme' => $theme->name, 'business' => $business->id]) }}"
                                   target="_blank" class="text-sm text-blue-600 hover:underline">
                                    Live Preview
                                </a>
                            </div>
                        </div>

                        {{-- “Selected” Badge --}}
                        <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded opacity-0 peer-checked:opacity-100">
                            Selected
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    ✅ Change Theme Only
                </button>
            </div>
        </form>

        {{-- 🔁 Regenerate Website (with Current Theme) --}}
        <form method="POST" action="{{ route('dashboard.websites.regenerate', $business->id) }}">
            @csrf
            <input type="hidden" name="theme_name" value="{{ $business->theme?->name }}">

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                🔁 Regenerate Website
            </button>
        </form>

    </div>
</x-app-layout>
