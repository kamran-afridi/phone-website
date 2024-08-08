<div>
    <select class="form-select form-control-solid @error('customer_id') is-invalid @enderror" id="customer_id"
        name="customer_id" wire:change="changeEvents($event.target.value)">
        <option selected="" disabled="">
            Select a customer:
        </option>

        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}">
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
    {{-- <div>
        <p>Latitude: {{ $latitude }}</p>
        <p>Longitude: {{ $longitude }}</p>
    </div> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // let map; 
            function initializeMap(latitude, longitude) {
                // map.setView(latitude, longitude);
                //     // console.log(position.coords.longitude);
                var currentCenter = map.getZoom();
                console.log(currentCenter);
                map.setView([latitude[0]['latitude'], latitude[0]['longitude']], currentCenter);
                zooMarker.setLatLng([latitude[0]['latitude'], latitude[0]['longitude']]);
                //     zooMarker.setLatLng([latitude, longitude]);
            }

            Livewire.on('locationUpdated', (latitude, longitude) => {
                initializeMap(latitude, longitude);
            });
        });
    </script>
</div>
