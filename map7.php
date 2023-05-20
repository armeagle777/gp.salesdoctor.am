<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Display a map on a webpage</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
<style>
body { margin: 0; padding: 0; }
#map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>
</head>
<body>

<?php 

$url="https://api.mapbox.com/optimized-trips/v1/mapbox/driving/44.51199004758428,40.18241188023322;40.151304546649946,44.51006810383575;40.15131923392046,44.51008587586425;40.12983459872819,44.52460105615077?source=first&destination=last&roundtrip=false&access_token=pk.eyJ1IjoibmFyZWtuYXJlazEiLCJhIjoiY2wxZG56anh6MGpkdDNkcDQxNGpsMmp2MyJ9.GdK1NCH58ZeflvcTDR461w";

$json = file_get_contents($url);
$data = json_decode($json,true);
var_dump($data);
echo "<br> <br>";
echo  $data["trips"][0]['distance'];




?>

<br>
<br><br>
<br><br><br><br>

 
</body>
</html>
