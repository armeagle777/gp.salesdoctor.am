<!DOCTYPE html>
<html>
  <head>
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 600px;  /* The width is 600 pixels */
       }
    </style>
  </head>
  <body>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
      // Initialize and add the map
      let map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: 41, lng: -86}
        });

        const cities = [
          {lat: 41.88, lng: -87.62}, // Chicago
          {lat: 43.05, lng: -87.95}, // Milwaukee
          {lat: 42.33, lng: -83.04}, // Detroit
          {lat: 39.76, lng: -86.15}, // Indianapolis
          {lat: 38.62, lng: -90.19} // St. Louis
        ];

        // Loop through cities, adding markers
        for (let i=0; i<cities.length; i++) {
          let position = cities[i]; // location of one city
          // create marker for a city
          let mk = new google.maps.Marker({position: position, map: map});
        }

        // Add Distance Matrix here
		const service = new google.maps.DistanceMatrixService(); // instantiate Distance Matrix service
      const matrixOptions = {
        origins: ["40.153095,44.5099669", "40.1597343,44.5119976", "40.145734062017006,44.529920813159116"], // technician locations
        destinations: ["11 Griboyedov st, Yerevan, Armenia"], // customer address
        travelMode: 'DRIVING',
        unitSystem: google.maps.UnitSystem.IMPERIAL
      };
      // Call Distance Matrix service
      service.getDistanceMatrix(matrixOptions, callback);

      // Callback function used to process Distance Matrix response
      function callback(response, status) {
        if (status !== "OK") {
          alert("Error with distance matrix");
          return;
        }
        console.log(response);        
      }
      }
	  
	  
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8&callback=initMap">
    </script>
  </body>
</html>