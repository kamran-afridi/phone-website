<div>
    <style id="compiled-css" type="text/css">
        #my-map {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />

    <div id="demo"></div>
    <div class="form-group">
        <label class="control-label">Map</label>
        <div style="width: 100%;height: 600px;border: 1px solid gray;border-radius: 3px;">
            <div id="my-map"></div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        // ul.appendChild(list);

        function showPosition(position) {
            //   const map = L.map('map', {zoomControl: false}).setView([38.908838755401035, -77.02346458179596], 12);
            var map = L.map("my-map").setView([53.8149662, -1.5148837], 16);

            // Get your own API Key on https://myprojects.geoapify.com
            //   var myAPIKey = "6dc7fb95a3b246cfa0f3bcef5ce9ed9a";
            var myAPIKey = "fef3d039831a43c48ce29513f31b27e2";

            // Retina displays require different mat tiles quality
            var isRetina = L.Browser.retina;

            var baseUrl =
                "https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}.png?apiKey=fef3d039831a43c48ce29513f31b27e2";
            var retinaUrl =
                "https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}@2x.png?apiKey=fef3d039831a43c48ce29513f31b27e2";

            // Add map tiles layer. Set 20 as the maximal zoom and provide map data attribution.
            L.tileLayer(isRetina ? retinaUrl : baseUrl, {
                // attribution: 'Powered by <a href="https://www.geoapify.com/" target="_blank">Geoapify</a> | © OpenStreetMap <a href="https://www.openstreetmap.org/copyright" target="_blank">contributors</a>',
                apiKey: myAPIKey,
                maxZoom: 20,
                id: "osm-bright",
            }).addTo(map);

            const zooMarkerPopup = L.popup().setContent('Current Location');
            const markerIcon = L.icon({
                iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=user&iconType=awesome&scaleFactor=2&apiKey=${myAPIKey}`,
                iconSize: [31, 46], // size of the icon
                iconAnchor: [15.5, 42], // point of the icon which will correspond to marker's location
                popupAnchor: [0, -45] // point from which the popup should open relative to the iconAnchor
            });
            const zooMarker = L.marker([position.coords.latitude, position.coords.longitude], {
                icon: markerIcon
            }).bindPopup(zooMarkerPopup).addTo(map);
        }
    </script>
</div>
