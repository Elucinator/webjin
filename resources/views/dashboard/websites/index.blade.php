<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            My Generated Websites
        </h2>
    </x-slot>

    <div class="py-10 px-6 max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 text-red-600 font-semibold">
                        {{ session('error') }}
                    </div>
                @endif
            @if($businesses->count())
                    <table class="w-full table-auto text-left">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <tr>
                            <th class="p-2">Name</th>
                            <th class="p-2">Theme</th>
                            <th class="p-2">Created</th>
                            <th class="p-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-700">
                        @foreach($businesses as $business)
                            <tr class="border-b">
                                <td class="p-2">{{ $business->name }}</td>
                                <td class="p-2">{{ $business->theme->label ?? 'N/A' }}</td>
                                <td class="p-2">{{ $business->created_at->format('d M Y') }}</td>
                                <td class="p-2 space-x-2">
                                    <a href="{{ route('websites.show', $business->id) }}" target="_blank"
                                       class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('dashboard.websites.regenerate.form', $business->id) }}" class="text-yellow-600 hover:underline">
                                        Regenerate
                                    </a>
                                    {{-- @csrf @method('DELETE') --}}
                                    {{-- <button class="text-red-600 hover:underline">Delete</button> --}}
                                    {{-- </form> --}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $businesses->links() }}
                    </div>
                @else
                    <p class="text-gray-600">No websites generated yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
