
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Google Maps JavaScript API v3 Example: Directions Waypoints (LatLng)</title>
<style type="text/css">
html { height: 100% }
body { height: 100%; margin: 0px; padding: 0px }
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8"></script>
<script type="text/javascript">
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;

  function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var chicago = new google.maps.LatLng(40.153095, 44.5099669);
    var myOptions = {
      zoom: 6,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: chicago
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);
    calcRoute();
  }
  
  function calcRoute() {

    var request = {
		
        // from: Blackpool to: Preston to: Blackburn
        origin: new google.maps.LatLng(40.145734062017006, 44.529920813159116),
		
        destination: new google.maps.LatLng(40.1597343,44.5119976),
		
        waypoints: [
		
		  {location: new google.maps.LatLng(40.1414499,44.52723982),
          stopover:true},	
		  
		  {location: new google.maps.LatLng(40.1339021,44.5337944),
          stopover:true},
		  
		  {location: new google.maps.LatLng(40.1409824,44.5337749),
          stopover:true},


		  
		
		  
		  
		  ],
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
        var route = response.routes[0];
        var summaryPanel = document.getElementById("directions_panel");
        summaryPanel.innerHTML = "";
        // For each route, display summary information.
        for (var i = 0; i < route.legs.length; i++) {
          var routeSegment = i + 1;
          summaryPanel.innerHTML += "<b>Route Segment: " + routeSegment + "</b><br />";
          summaryPanel.innerHTML += route.legs[i].start_address + " to ";
          summaryPanel.innerHTML += route.legs[i].distance.text + "<br /><br/>";
          summaryPanel.innerHTML += route.waypoint_order[i] + "<br /><br/>";
        }
		
		console.log(route);
        computeTotalDistance(response);
      } else {
        alert("directions response "+status);
      }
    });
  }

      function computeTotalDistance(result) {
      var totalDist = 0;
      var totalTime = 0;
      var myroute = result.routes[0];
      for (i = 0; i < myroute.legs.length; i++) {
        totalDist += myroute.legs[i].distance.value;
        totalTime += myroute.legs[i].duration.value;      
      }
      totalDist = totalDist / 1000.
      document.getElementById("total").innerHTML = "total distance is: "+ totalDist + " km<br>total time is: " + (totalTime / 60).toFixed(2) + " minutes";
      }
</script>
</head>
<body onload="">
<script type="text/javascript">
initialize();
</script>
<div id="map_canvas" style="float:left;width:300px;height:300px;"></div>
<div id="control_panel" style="float:left;width:300px;text-align:left;padding-top:20px">
<div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>
<div id="total"></div>
</div> 
</body>
</html>
