<div>
    <style id="compiled-css" type="text/css">
        #my-map {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>

    <div>
        <p>Latitude: {{ $latitude }}</p>
        <p>Longitude: {{ $longitude }}</p>
    </div>
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
