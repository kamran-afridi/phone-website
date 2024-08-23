<div>
    <select class="form-select form-control-solid @error('customer_id') is-invalid @enderror" id="customer_id"
        name="customer_id" wire:change="changeEvents($event.target.value)">
        <option value="" selected="" disabled="">
            Select a customer:
        </option>

        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" @selected(old('customer_id', $customer_id) == $customer->id)>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
    <div class="mt-3">
        <p> <b>Latitude:</b> {{ $getlatitude }}</p>
        <p> <b>Longitude:</b> {{ $getlongitude }}</p>
        <input type="hidden" name="getlatitude" id="getlatitude" value="{{ $getlatitude }}">
        <input type="hidden" name="getlongitude" id="getlongitude" value="{{ $getlongitude }}">
    </div>
    <script>
        $('#customer_id').on('change', function() {
            setInterval(function() {
                var selectedCustomerId = document.getElementById('customer_id').value;
                let getlatitude = document.getElementById('getlatitude').value;
                let getlongitude = document.getElementById('getlongitude').value;
                if (selectedCustomerId) {
                    Livewire.dispatch('getlocation', {
                        customer_id: selectedCustomerId,
                    });
                    if (getlongitude == 'Not detected') {
                        getlongitude = 0.000;
                        getlatitude = -0.000;
                    }
                    initializeMap(getlatitude, getlongitude);
                    console.log(selectedCustomerId);
                    // console.log(getlatitude, getlongitude);
                }
            }, 20000);
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //  wire:change="changeEvents($event.target.value)"
        // Set an interval to trigger the changeEvents method every 500ms
        // setInterval(function() {
        // var selectedCustomerId = document.getElementById('customer_id').value; 
        // if (selectedCustomerId) {
        // Trigger the Livewire component's changeEvents method
        // Livewire.on('changeEvents', selectedCustomerId);
        // Livewire.on('locationUpdated', selectedCustomerId);
        // Livewire.on('locationUpdated', (latitude, longitude) => {
        //     initializeMap(latitude, longitude);
        // });
        // console.log(selectedCustomerId);
        // }
        // }, 100000); 
        function initializeMap(getlatitude, getlongitude) {
            console.log(getlatitude + " " + getlongitude);
            var currentCenter = map.getZoom();
            // console.log(currentCenter);
            map.setView([getlatitude, getlongitude], currentCenter);
            zooMarker.setLatLng([getlatitude, getlongitude]);
            zooMarker.setLatLng([getlatitude, getlongitude]);
        }
        // Livewire.on('locationUpdated', (latitude, longitude) => {
        // initializeMap(latitude, longitude);
        // });
        // setInterval(function() {
        //     @this.$refresh(); 
        // }, 120000); // 120000 milliseconds = 2 minutes
        // });
    </script>
</div>
