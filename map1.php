<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Directions Waypoints</title>
<style>
    #map{
    width: 100%;
    height: 450px;
}
</style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8&callback=initMap">
    </script>    <script>
      var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: true
    });

    var myOptions = {
        zoom: 3,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    }

    map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    directionsDisplay.setMap(map);
    calcRoute();
}

function calcRoute() {

    var waypts = [];

    stop = new google.maps.LatLng(51.943571, 6.463856)
    waypts.push({
        location: stop,
        stopover: true
    });
    stop = new google.maps.LatLng(51.945032, 6.465776)
    waypts.push({
        location: stop,
        stopover: true
    });
    stop = new google.maps.LatLng(51.945538, 6.469413)
    waypts.push({
        location: stop,
        stopover: true
    });
    stop = new google.maps.LatLng(51.947462, 6.467941)
    waypts.push({
        location: stop,
        stopover: true
    });
    stop = new google.maps.LatLng(51.945409, 6.465562)
    waypts.push({
        location: stop,
        stopover: true
    });
    stop = new google.maps.LatLng(51.943700, 6.462096)
    waypts.push({
        location: stop,
        stopover: true
    });

    start = new google.maps.LatLng(51.943382, 6.463116);
    end = new google.maps.LatLng(51.943382, 6.463116);
    
    createMarker(start);
    
    var request = {
        origin: start,
        destination: end,
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.WALKING
    };

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
        }
    });
}

function createMarker(latlng) {
    
    var marker = new google.maps.Marker({
        position: latlng,
        map: map
    });
}

initialize();
    </script>
  </head>
  <body>
<div id="map-canvas"></div>
</body>
</html>