<html>
<head>
    <title>State Selection Map</title>
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 39.8283, lng: -98.5795}, // Set the initial map center to the United States coordinates
                zoom: 15 // Set the initial zoom level
            });

            var geocoder = new google.maps.Geocoder();

            map.addListener('click', function(event) {
                geocoder.geocode({ location: event.latLng }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            var state = extractStateFromAddressComponents(results[0].address_components);
                            if (state) {
                                console.log('Selected state:', state);
                                // Perform any desired action with the selected state
                            }
                        }
                    } else {
                        console.error('Geocode failed due to: ' + status);
                    }
                });
            });

            function extractStateFromAddressComponents(addressComponents) {
                for (var i = 0; i < addressComponents.length; i++) {
                    var types = addressComponents[i].types;
                    if (types.indexOf('administrative_area_level_1') !== -1) {
                        return addressComponents[i].short_name;
                    }
                }
                return null;
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
</body>
</html>
