<!DOCTYPE html>
<html>
  <head>
    <style>
       /* Set the size of the div element that contains the map */
      #dvMap {
        height: 400px;  /* The height is 400 pixels */
        width: 600px;  /* The width is 600 pixels */
       }
    </style>
  </head>
  <body>
    <!--The div element for the map -->

    <div id="dvMap"></div>
    <script type="text/javascript">
 
 window.onload = function() {
  var mapOptions = {
    center: new google.maps.LatLng(markers[0].latitude, markers[0].longitude),
    zoom: 10,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
  var infoWindow = new google.maps.InfoWindow();
  var lat_lng = new Array();
  var latlngbounds = new google.maps.LatLngBounds();
  for (i = 0; i < markers.length; i++) {
    var data = markers[i]
    var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
    lat_lng.push(myLatlng);
    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: data.timestamp
    });
    // console.log(i)

    latlngbounds.extend(marker.position);
    (function(marker, data) {
      google.maps.event.addListener(marker, "click", function(e) {
        infoWindow.setContent(data.timestamp);
        infoWindow.open(map, marker);
      });
    })(marker, data);
  }
  map.setCenter(latlngbounds.getCenter());
  map.fitBounds(latlngbounds);

  //***********ROUTING****************//


  //Initialize the Direction Service
  var service = new google.maps.DirectionsService();




  //Loop and Draw Path Route between the Points on MAP
  for (var i = 0; i < lat_lng.length; i++) {
    if ((i + 1) < lat_lng.length) {
      var src = lat_lng[i];
      var des = lat_lng[i + 1];
      // path.push(src);

      service.route({
        origin: src,
        destination: des,
        travelMode: google.maps.DirectionsTravelMode.WALKING
      }, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {

          //Initialize the Path Array
          var path = new google.maps.MVCArray();
          //Set the Path Stroke Color
          var poly = new google.maps.Polyline({
            map: map,
            strokeColor: '#4986E7'
          });
          poly.setPath(path);
          for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
            path.push(result.routes[0].overview_path[i]);
          }
        }
      });
    }
  }
}

	  
    </script>
   
  </body>
</html>