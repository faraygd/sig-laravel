<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemetaan Sekolah SMA Purwokerto Timur</title>
    <!-- Leaflet CSS-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.min.js"></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
  rel='stylesheet' />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #map {
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <!-- Leaflet JS-->
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <script>
        var myLat = -7.4352631; // Default Latitude
        var myLong = 109.2469039; // Default Longitude
        var map = L.map('map', {
            center: [myLat, myLong],
            zoom: 18,
            layers: [],
            fullscreenControl: true,
            fullscreenControlOptions: { // optional
                title: "Show me the fullscreen !",
                titleCancel: "Exit fullscreen mode"
            }
        });
        // Model Map
        var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
        var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {});
        var mapdark = L.tileLayer(
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}", {
            id: "mapbox/dark-v10",
            tileSize: 512,
            zoomOffset: -1,
            accessToken: "pk.eyJ1Ijoic25vd3JleCIsImEiOiJjazhmbTd4cG8wNXN0M2ZzMDFpZGNoaWpmIn0.GgO0rwaNrkc-eqVt6DeM3g",
        });
        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        });

        var baseMaps = {
            "Open Street Map Mapnik": OpenStreetMap_Mapnik,
            "Google Satellite": GoogleSatelliteHybrid,
            "Open Street Map Dark": mapdark,
            "Google Street": googleStreets,
        };
        var layerControl = L.control.layers(baseMaps).addTo(map);
        // Function for pop up marker
        function popUp(feature,layer) {
            layer.bindPopup(
                "<h2>"+feature.nama_sekolah+
            // Customize
                "<h3>"+feature.properties.alamat_sekolah+
                "<br><br><a href=http://"+feature.properties.Website+ ">" +feature.properties.Website+ "</a>" +
                "<br>"
        )};
        var geojsonLayer = new L.GeoJSON.AJAX("../map/school.geojson", {onEachFeature: popUp}); 
        geojsonLayer.on('data:loaded', function () {
            geojsonLayer.addTo(map);
            map.fitBounds(geojsonLayer.getBounds());
        });
    </script>
</body>

</html>