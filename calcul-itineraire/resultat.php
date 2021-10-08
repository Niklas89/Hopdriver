<?php


$origin = $_GET['origin'];
$destination = $_GET['destination'];


?>

<!DOCTYPE html> 
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Calcul d'itinéraire Google Map Api v3</title>
    <link rel="stylesheet" href="jquery-ui-1.8.12.custom.css" type="text/css" /> 
  </head>
  <style type="text/css">
    body{font-family:Arial;background:#000000;margin:0px;padding:0px;}
    #container{position:relative;width:990px;margin:auto;background:#FFFFFF;padding:20px 0px 20px 0px;}
    #container h1{margin:0px 0px 10px 20px;}
    #container #map{width:260px;height:260px;margin:auto;}
    #container #panel{width:700px;margin:auto;}
    #container #destinationForm{margin:0px 0px 20px 0px;background:#EEEEEE;padding:10px 20px;border:solid 1px #C0C0C0;}
    #container #destinationForm input[type=text]{border:solid 1px #C0C0C0;}
  </style>
  <body>
    <div id="container">
        <h1>Calcul d'itinéraire Google Maps Api V3</h1>
        <div id="destinationForm">
            <form action="" method="get" name="direction" id="direction">
                <label>Point de départ :</label>
                <input type="text" value="<?php echo $origin; ?>" name="origin" id="origin">
                <label>Destination :</label>
                <input type="text" value="<?php echo $destination; ?>" name="destination" id="destination">
                <input type="button" value="Calculer l'itinéraire"> 
                
            </form>
        </div>
        <div id="panel"></div> 
        <div id="map">
            <p>Veuillez patienter pendant le chargement de la carte...</p>
        </div> 


        <?php
        $from = "165 bd Bineau, 92200";
$to = "Terminal 2F, Paris-Charles De Gaulle (CDG), 93290 Tremblay-en-France, France";

$from = urlencode($from);
$to = urlencode($to);

$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=driving&language=en-EN&sensor=true");
$data = json_decode($data);

$time = 0;
$distance = 0;

foreach($data->rows[0]->elements as $road) {
    $time += $road->duration->text;
    $distance += $road->distance->text;
}

echo "To: ".$data->destination_addresses[0];
echo "<br/>";
echo "From: ".$data->origin_addresses[0];
echo "<br/>";
echo "Time: ".$time." mins";
echo "<br/>";
echo "Distance: ".$distance." km"; ?>
    </div>
    
    <!-- Include Javascript -->
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="jquery-ui-1.8.12.custom.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=en"></script>
    <script type="text/javascript" src="functions.js"></script>
   

  </body>
</html>
