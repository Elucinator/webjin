<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Website Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div>
                    <input
                        type="text"
                        id="businessSearch"
                        placeholder="Type your business name..."
                        class="w-full border rounded p-2 mb-4"
                    />

                    <ul id="results" class="space-y-2"></ul>

                    <div id="businessPreview" class="mt-6 hidden border rounded p-4 bg-gray-100">
                        <h2 class="text-xl font-semibold mb-2" id="bizName"></h2>
                        <p><strong>Address:</strong> <span id="bizAddress"></span></p>
                        <p><strong>Phone:</strong> <span id="bizPhone"></span></p>
                        <p><strong>Website:</strong> <span id="bizWebsite"></span></p>
                        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded" onclick="generateWebsite()">Generate Website</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('businessSearch');
        const resultsBox = document.getElementById('results');
        const previewBox = document.getElementById('businessPreview');

        let debounceTimer;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const q = this.value;
                if (q.length < 3) return;

                fetch(`/business/search?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => {
                        resultsBox.innerHTML = '';
                        (data.results || []).forEach(item => {
                            const li = document.createElement('li');
                            li.className = "cursor-pointer p-2 bg-white border rounded hover:bg-gray-100";
                            li.textContent = item.name + ' - ' + item.formatted_address;
                            li.onclick = () => selectBusiness(item.place_id);
                            resultsBox.appendChild(li);
                        });
                    });
            }, 500);
        });

        function selectBusiness(placeId) {
            fetch(`/business/details?place_id=${placeId}`)
                .then(res => res.json())
                .then(data => {
                    const info = data.result;
                    document.getElementById('bizName').textContent = info.name || '';
                    document.getElementById('bizAddress').textContent = info.formatted_address || '';
                    document.getElementById('bizPhone').textContent = info.formatted_phone_number || '';
                    document.getElementById('bizWebsite').textContent = info.website || '';
                    previewBox.classList.remove('hidden');
                    previewBox.dataset.placeId = placeId;
                    previewBox.dataset.businessJson = JSON.stringify(info);
                });
        }

        function generateWebsite() {
            const data = {
                place_id: document.getElementById('businessPreview').dataset.placeId,
                business_json: document.getElementById('businessPreview').dataset.businessJson
            };

            fetch('/generate-site-from-google', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            }).then(res => res.json())
              .then(res => {
                  alert('Website created! URL: ' + res.url);
                  window.location.href = res.url;
              });
        }
    </script>
</x-app-layout>
