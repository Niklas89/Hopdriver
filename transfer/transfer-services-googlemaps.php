<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; } 
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

include '../config.php';

require "localization.php"; 

if (isset($_POST["transfer-services"])) {
$origin = $_POST['origin'];
$destination = $_POST['destination'];
$pickupdate = $_POST['start'];
$pickuptime = $_POST['pickuptime'];

if (!empty($_POST["end"]) && !empty($_POST["returntime"]) ) {
$returndate = $_POST['end'];
$returntime = $_POST['returntime']; }

}
else {
    $origin = "CDG Charles De Gaulle Airport, Roissy-en-France, France";
    $destination = "3 Rue Caulaincourt, 75018 Paris, France";
    date_default_timezone_set('Europe/Madrid');
    $pickupdate = date('d M Y');
    $pickuptime = date('H:i');
}

date_default_timezone_set('Europe/Madrid');
      $current_time = date('H:i');

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver -  <?php echo _("Transfer Services"); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('Transfer Services'); ?>" />
    <meta name="description" content="<?php echo _('Transfer Services'); ?>">
    <meta name="author" content="Niklas Edelstam">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/icomoon.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/mystyles.css">
    <script src="../js/modernizr.js"></script>
    <style type="text/css">
   
    #map{width:260px;height:260px;}
  </style>


</head>

<body>

    <div class="global-wrap">
        
        <?php include '../header_transfers.php'; ?>


        <div class="container">
            <ul class="breadcrumb">
                <li><a action="../index.php" title="<?php echo _('Previous'); ?>"><?php echo _("Home"); ?></a>
                </li> <!--
                <li><a href="#">France</a>
                </li>
                <li><a href="#">Paris</a>
                </li> -->
                <li class="active"><?php echo _("Transfer Services"); ?></li>
            </ul>

            <h3 class="booking-title"><?php echo _("Select your category"); ?></h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="booking-item-dates-change mb30">
                        <form class="input-daterange" data-date-format="d M yyyy" action="transfer-services.php" method="post">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label><?php echo _("From"); ?></label>
                                <input class="typeahead form-control" value="<?php echo $origin; ?>" placeholder="<?php echo _('City or Airport'); ?>" type="text" name="origin" id="origin" onclick="initializetransfer()" onFocus="geolocate()"  />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Pick-Up Date"); ?></label>
                                        <input class="form-control" value="<?php if (!empty($_POST["start"])) { echo $pickupdate; } else { echo " "; } ?>" name="start" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Pick-Up Time"); ?></label>
                                        <input class="time-pick form-control" value="<?php if (!empty($_POST["pickuptime"])) { echo $pickuptime; } else { echo $current_time; } ?>" name="pickuptime" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label><?php echo _("To"); ?></label>
                                <input class="typeahead form-control" value="<?php echo $destination; ?>" placeholder="<?php echo _('City or Airport'); ?>" type="text"  name="destination" id="destination" onclick="initializetransferto()" onFocus="geolocate()"  />
                            </div>
                            <?php if (!empty($_POST["end"]) && !empty($_POST["returntime"])) { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Return Date"); ?></label>
                                        <input class="form-control" value="<?php if (!empty($_POST["end"])) { echo $returndate; } else { echo ""; } ?>" name="end" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Return Time"); ?></label>
                                        <input class="time-pick form-control" value="<?php if (!empty($_POST["returntime"])) { echo $returntime; } else { echo $current_time; } ?>" name="returntime" type="text" />
                                    </div>
                                </div>
                            </div> <?php } else { echo ""; } ?>

                                 <?php if (isset($_POST["transfer-services"])) { 
                                        $from = $origin;
                                $to = $destination;

                                $pickupdate = date("d M Y", strtotime($_POST["start"]));
                                 $pickuptime = date("H:i", strtotime($pickuptime));

                                if (!empty($returndate) && !empty($returntime) ) {
                                $returndate = date("d M Y", strtotime($_POST["end"]));
                                 $returntime = date("H:i", strtotime($returntime));
                                 }



                                $from = urlencode($from);
                                $to = urlencode($to);

                                $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=driving&language=en-EN");
                                $data = json_decode($data);

                                /*
                                // We get the JSON results from this request
                                $geofrom = file_get_contents('https://maps.googleapis.com/maps/api/place/autocomplete/json?input=Vict&types=(cities)&language=en_EN');
                                // We convert the JSON to an array
                                $geofrom = json_decode($geofrom, true);
                                // If everything is cool
                                if ($geofrom['status'] = 'OK') {
                                  // We set our values
                                  $latitude_from = $geofrom['results'][0]['geometry']['location']['lat'];
                                  $longitude_from = $geofrom['results'][0]['geometry']['location']['lng'];
                                  $latlng_from = $latitude_from.','.$longitude_from;
                                }*/


                                // We get the JSON results from this request
                                $geofrom = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$from);
                                // We convert the JSON to an array
                                $geofrom = json_decode($geofrom, true);
                                // If everything is cool
                                if ($geofrom['status'] = 'OK') {
                                  // We set our values
                                  $latitude_from = $geofrom['results'][0]['geometry']['location']['lat'];
                                  $longitude_from = $geofrom['results'][0]['geometry']['location']['lng'];
                                  $latlng_from = $latitude_from.','.$longitude_from;
                                  // http://stanhub.com/get-latitude-longitude-coordinates-from-postcode-address-using-google-api-display-google-map/
                                }


                                // We get the JSON results from this request
                                $geoto = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$to);
                                // We convert the JSON to an array
                                $geoto = json_decode($geoto, true);
                                // If everything is cool
                                if ($geoto['status'] = 'OK') {
                                  // We set our values
                                  $latitude_to = $geoto['results'][0]['geometry']['location']['lat'];
                                  $longitude_to = $geoto['results'][0]['geometry']['location']['lng'];
                                  $latlng_to = $latitude_to.','.$longitude_to;

                                }


                                $geofrom_reverse =  file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlng_from);
                                $geofrom_reverse = json_decode($geofrom_reverse, true);
                                if ($geofrom_reverse['status'] = 'OK') {
                                  $latlng_from_address = $geofrom_reverse['results'][0]['formatted_address'];
                                  $latlng_from_address_components_city = $geofrom_reverse['results']['address_components'][0]['long_name'];
                                }


                                $geoto_reverse =  file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlng_to);
                                $geoto_reverse = json_decode($geoto_reverse, true);
                                if ($geoto_reverse['status'] = 'OK') {
                                  $latlng_to_address = $geoto_reverse['results'][0]['formatted_address'];
                                }

                                $time = 0;
                                $distance = 0;

                                foreach($data->rows[0]->elements as $road) {
                                    $time += $road->duration->text;
                                    $distance += $road->distance->text;
                                }

                                

                                    
                                     $sth = $bdd->prepare("SELECT MIN(NULLIF(minimum_ecocar, 0)) AS smallestecocar,
                                         MIN(NULLIF(minimum_ecovan, 0)) AS smallestecovan,
                                          MIN(NULLIF(minimum_buscar, 0)) AS smallestbuscar,
                                           MIN(NULLIF(minimum_busvan, 0)) AS smallestbusvan,
                                            MIN(NULLIF(minimum_luxcar, 0)) AS smallestluxcar,
                                             MIN(NULLIF(minimum_moto, 0)) AS smallestmoto,
                                              MIN(NULLIF(minimum_coach, 0)) AS smallestcoach
                                      FROM driver_prices");
                                        $sth->execute();
                                        $result = $sth->fetch(PDO::FETCH_OBJ);
                                        $sth->closeCursor();
                                        $minimum_economycar = $result->smallestecocar;
                                        $minimum_economyvan = $result->smallestecovan;
                                        $minimum_businesscar = $result->smallestbuscar;
                                        $minimum_businessvan = $result->smallestbusvan;
                                        $minimum_luxurycar = $result->smallestluxcar;
                                        $minimum_motorcycle = $result->smallestmoto;
                                        $minimum_coach = $result->smallestcoach;

                               



                                    
                                     $sth = $bdd->prepare("SELECT MIN(NULLIF(ecocar, 0)) AS smallestecocar,
                                         MIN(NULLIF(ecovan, 0)) AS smallestecovan,
                                          MIN(NULLIF(buscar, 0)) AS smallestbuscar,
                                           MIN(NULLIF(busvan, 0)) AS smallestbusvan,
                                            MIN(NULLIF(luxcar, 0)) AS smallestluxcar,
                                             MIN(NULLIF(moto, 0)) AS smallestmoto,
                                              MIN(NULLIF(coach, 0)) AS smallestcoach
                                      FROM driver_prices");
                                        $sth->execute();
                                        $result = $sth->fetch(PDO::FETCH_OBJ);
                                        $sth->closeCursor();
                                        $kmecocar = $result->smallestecocar;
                                        $kmecovan = $result->smallestecovan;
                                        $kmbuscar = $result->smallestbuscar;
                                        $kmbusvan = $result->smallestbusvan;
                                        $kmluxcar = $result->smallestluxcar;
                                        $kmmoto = $result->smallestmoto;
                                        $kmcoach = $result->smallestcoach;



                                $economycar = round($distance*$kmecocar);
                                $economyvan = round($distance*$kmecovan);
                                $businesscar = round($distance*$kmbuscar);
                                $businessvan = round($distance*$kmbusvan);
                                $luxurycar = round($distance*$kmluxcar);
                                $motorcycle = round($distance*$kmmoto);
                                $coach = round($distance*$kmcoach);

                                if($economycar < $minimum_economycar){ $economycar = $minimum_economycar; $minimum_service = "minimum_"; } else { $minimum_service = ""; }
                                if($economyvan < $minimum_economyvan){ $economyvan = $minimum_economyvan; $minimum_service = "minimum_";  }  else { $minimum_service = ""; }
                                if($businesscar < $minimum_businesscar){ $businesscar = $minimum_businesscar; $minimum_service = "minimum_";  }  else { $minimum_service = ""; }
                                if($businessvan < $minimum_businessvan){ $businessvan = $minimum_businessvan; $minimum_service = "minimum_";  }  else { $minimum_service = ""; }
                                if($luxurycar < $minimum_luxurycar){ $luxurycar = $minimum_luxurycar; $minimum_service = "minimum_";  }  else { $minimum_service = ""; }
                                if($motorcycle < $minimum_motorcycle){ $motorcycle = $minimum_motorcycle; $minimum_service = "minimum_";  }  else { $minimum_service = ""; }
                                if($coach < $minimum_coach){ $coach = $minimum_coach; $minimum_service = "minimum_";  }   else { $minimum_service = ""; }

                                

                                ?>
                            
                                <div class="form-group form-group-icon-left">
                                        <label><?php echo _('Distance'); ?>: <?php echo $distance; ?> <?php echo _('km'); ?></label>
                                        <label><?php echo _('Duration'); ?>: <?php echo $time; ?> <?php echo _('mins'); ?></label>
                                        <label><?php echo _('longitude FROM'); ?>: <?php echo $longitude_from; ?></label>
                                        <label><?php echo _('latitude FROM'); ?>: <?php echo $latitude_from; ?> </label>
                                        <label><?php echo _('longitude TO'); ?>: <?php echo $longitude_to; ?></label>
                                        <label><?php echo _('latitude TO'); ?>: <?php echo $latitude_to; ?> </label>
                                        <label><?php echo _('Formated address FROM'); ?>: <?php echo $latlng_from_address; ?> </label>
                                        <label><?php echo _('Formated address city FROM'); ?>: <?php echo $latlng_from_address_components_city; ?> </label>
                                        <label><?php echo _('Formated address TO'); ?>: <?php echo $latlng_to_address; ?> </label>


                                        <?php 

                                        // GET CITY, DEPARTEMENT, REGION OR COUNTRY FROM ADDRESS OR CITY OR COUNTRY OR WHATEVER //
                                        function reverse_geocode($address) {
                                            $address = str_replace(" ", "+", "$address");
                                            $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
                                            $result = file_get_contents("$url");
                                            $json = json_decode($result);
                                            foreach ($json->results as $result) {
                                                foreach($result->address_components as $addressPart) {
                                                  if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $city = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_2', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $dept = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $state = $addressPart->long_name;
                                                    else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $country = $addressPart->long_name;
                                                }
                                            }
                                            
                                            if(($city != '') && ($dept != '') && ($state != '') && ($country != ''))
                                                $address = $city.', '.$dept.', '.$state.', '.$country;
                                            else if(($city != '') && ($state != '') && ($country != ''))
                                                $address = $city.', '.$state.', '.$country;
                                            else if(($city != '') && ($state != ''))
                                                $address = $city.', '.$state;
                                            else if(($state != '') && ($country != ''))
                                                $address = $state.', '.$country;
                                            elseif($country != '')
                                                $address = $country;
                                                
                                            // return $address;
                                            return "$country/$dept/$state/$city";
                                        }
                                         
                                        /* Usage: In my case, I needed to return the State and Country of an address */
                                        $myLocationFrom = reverse_geocode('165 Boulevard Bineau, Neuilly-sur-Seine, France');
                                        echo $myLocationFrom.'<br />';
                                        $myLocationTo = reverse_geocode('Sibyllegatan 33, Stockholm, Sweden');
                                        echo $myLocationTo;

                                        

                                        // GET CITY, DEPARTEMENT, REGION OR COUNTRY FROM LATITUDE AND LONGITUDE //
                                            function reverse_geocode($address) {
                                            $address = str_replace(" ", "+", "$address");
                                            $url = "http://maps.google.com/maps/api/geocode/json?latlng=$address&language=sv";
                                            $result = file_get_contents("$url");
                                            $json = json_decode($result);
                                            foreach ($json->results as $result) {
                                                foreach($result->address_components as $addressPart) {
                                                  if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $city = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_2', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $dept = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $state = $addressPart->long_name;
                                                    else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $country = $addressPart->long_name;
                                                }
                                            }
                                            
                                            if(($city != '') && ($dept != '') && ($state != '') && ($country != ''))
                                                $address = $city.', '.$dept.', '.$state.', '.$country;
                                            else if(($city != '') && ($state != '') && ($country != ''))
                                                $address = $city.', '.$state.', '.$country;
                                            else if(($city != '') && ($state != ''))
                                                $address = $city.', '.$state;
                                            else if(($state != '') && ($country != ''))
                                                $address = $state.', '.$country;
                                            elseif($country != '')
                                                $address = $country;
                                                
                                            // return $address;
                                            return "$country/$dept/$state/$city";
                                        }
                                         
                                        /* Usage: In my case, I needed to return the State and Country of an address */
                                        $myLocationFrom = reverse_geocode('59.336678,18.080182');
                                        echo $myLocationFrom.'<br />';

                                        ?>

                                        <?php 
                                        // GET CITY, DEPARTEMENT, REGION OR COUNTRY FROM LATITUDE AND LONGITUDE ---- WITH POSTAL CODE AND COUNTRY SHORT_NAME ALSO //
                                            function reverse_geocode($address) {
                                            $address = str_replace(" ", "+", "$address");
                                            $url = "http://maps.google.com/maps/api/geocode/json?latlng=$address&language=en";
                                            $result = file_get_contents("$url");
                                            $json = json_decode($result);
                                            foreach ($json->results as $result) {
                                                foreach($result->address_components as $addressPart) {
                                                  if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $city = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_2', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $dept = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $state = $addressPart->long_name;
                                                    else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $country = $addressPart->short_name;
                                                    else if((in_array('postal_code', $addressPart->types)))
                                                  $postal = $addressPart->long_name;
                                                }
                                            }
                                            
                                            if(($city != '') && ($dept != '') && ($state != '') && ($country != '') && ($postal != ''))
                                                $address = $city.', '.$dept.', '.$state.', '.$country.', '.$postal;
                                            else if(($city != '') && ($dept != '') && ($state != '') && ($country != ''))
                                                $address = $city.', '.$dept.', '.$state.', '.$country;
                                            else if(($city != '') && ($state != '') && ($country != ''))
                                                $address = $city.', '.$state.', '.$country;
                                            else if(($city != '') && ($state != ''))
                                                $address = $city.', '.$state;
                                            else if(($state != '') && ($country != ''))
                                                $address = $state.', '.$country;
                                            elseif($country != '')
                                                $address = $country;
                                                
                                            // return $address;
                                            return "$postal<br />$country<br />$dept<br />$state<br />$city";
                                        }
                                         
                                        /* Usage: In my case, I needed to return the State and Country of an address */
                                        $myLocationFrom = reverse_geocode($latlng_to);
                                        echo $myLocationFrom.'<br />';

                                        ?>
                                </div>
                                <?php } else { echo ""; } ?>
                            <input class="btn btn-primary" type="submit" name="transfer-services" value="<?php echo _('Update Details'); ?>" />
                        </form>
                    </div>

                    <div>
                       <div id="map">
                            <p><?php echo _("Loading itinerary..."); ?></p>
                        </div> 
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="nav-drop booking-sort">

            
                    </div>
                    <ul class="booking-list">


                        <!-- //////////////////// ECOCAR /////////////////////////// -->

                        <li>
                            <form id="form-ecocar" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-ecocar').submit();" title="<?php echo _('Select Economy Transfer'); ?>"> 

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/peugeot508.png" alt="<?php echo _('Economy Class'); ?>" title="<?php echo _('Economy Class'); ?>" />
                                            <!--<p class="booking-item-car-title">><?php echo _("Economy Class"); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Sedan Economy"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('FM Radio'); ?>"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Stereo CD/MP3'); ?>"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Air Conditioning'); ?>"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Phone Charger'); ?>"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Bottle of Water'); ?>"><i class="fa fa-glass"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $economycar; ?>€</span><br /><!--<span><?php echo _("Economy Class"); ?></span>-->
                                        <p class="booking-item-flight-class"> <br /></p><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $economycar; ?>" />
                                    <input type="hidden" name="services" value="ecocar" />
                                </div>
                            </a></form>
                        </li>


                        <!-- //////////////////// ECOVAN /////////////////////////// -->



                        <li>
                            <form id="form-ecovan" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-ecovan').submit();" title="<?php echo _('Select Economy Transfer'); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/caravelle.png" alt="<?php echo _('Economy Class'); ?>" title="<?php echo _('Economy Class'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _("Van Economy"); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Van Economy"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 8</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 8</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('FM Radio'); ?>"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Stereo CD/MP3'); ?>"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Air Conditioning'); ?>"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Phone Charger'); ?>"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Bottle of Water'); ?>"><i class="fa fa-glass"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Shuttle Bus to Car'); ?>"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $economyvan; ?>€</span><br /><!--<span><?php echo _('Economy Class'); ?></span>-->
                                        <p class="booking-item-flight-class"><br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $economyvan; ?>" />
                                    <input type="hidden" name="services" value="ecovan" />
                                </div>
                            </a></form>
                        </li>


                        <!-- //////////////////// BUSCAR /////////////////////////// -->



                        <li>
                            <form id="form-id" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-id').submit();" title="<?php echo _('Select Business Transfer'); ?>"> 

  
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/mbeclass.png" alt="<?php echo _('Business Class'); ?>" title="<?php echo _('Business Class'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Business Class'); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Sedan Business"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('FM Radio'); ?>"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Stereo CD/MP3'); ?>"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Air Conditioning'); ?>"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Phone Charger'); ?>"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Bottle of Water'); ?>"><i class="fa fa-glass"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Wifi'); ?>"><i class="fa fa-signal"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $businesscar; ?>€</span><br /><!--<span><?php echo _('Business Class'); ?></span>-->
                                        <p class="booking-item-flight-class"><br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $businesscar; ?>" />
                                    <input type="hidden" name="services" value="buscar" />
                                </div>
                            </a></form>
                        </li>


                        <!-- //////////////////// BUSVAN /////////////////////////// -->


                        <li>
                            <form id="form-idviano" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-idviano').submit();" title="<?php echo _('Select Business Transfer'); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/mbviano.png" alt="<?php echo _('Business Class'); ?>" title="<?php echo _('Business Class'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Business Class'); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Van Business"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 7</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 7</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('FM Radio'); ?>"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Stereo CD/MP3'); ?>"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Air Conditioning'); ?>"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Phone Charger'); ?>"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Bottle of Water'); ?>"><i class="fa fa-glass"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Wifi'); ?>"><i class="fa fa-signal"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Shuttle Bus to Car'); ?>"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $businessvan; ?>€</span><br /><!--<span><?php echo _('Business Class'); ?></span>-->
                                        <p class="booking-item-flight-class"><br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $businessvan; ?>" />
                                    <input type="hidden" name="services" value="busvan" />
                                </div>
                            </a></form>
                        </li>


                        <!-- //////////////////// LUXCAR /////////////////////////// -->


                        <li>
                            <form id="form-luxcar" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-luxcar').submit();" title="<?php echo _('Select Luxury Transfer'); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/mbsclass.png" alt="<?php echo _('Luxury Class'); ?>" title="<?php echo _('Luxury Class'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Sedan Luxury'); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Sedan Luxury"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('FM Radio'); ?>"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Stereo CD/MP3'); ?>"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Air Conditioning'); ?>"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Phone Charger'); ?>"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Bottle of Water'); ?>"><i class="fa fa-glass"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Wifi'); ?>"><i class="fa fa-signal"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $luxurycar; ?>€</span><br /><!--<span><?php echo _('First Class'); ?></span>-->
                                        <p class="booking-item-flight-class"><br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $luxurycar; ?>" />
                                    <input type="hidden" name="services" value="luxcar" />
                                </div>
                            </a></form>
                        </li>


                        <!-- //////////////////// MOTO /////////////////////////// -->


                        <li>
                            <form id="form-moto" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-moto').submit();" title="<?php echo _('Select Motorcycle Transfer'); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/bigger/moto.png" alt="<?php echo _('Motorcycle'); ?>" title="<?php echo _('Motorcycle'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Motorcycle'); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Motorcycle"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 1</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 1</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $motorcycle; ?>€</span><br /><!--<span><?php echo _('Motorcycle'); ?></span>-->
                                        <p class="booking-item-flight-class"><br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $motorcycle; ?>" />
                                    <input type="hidden" name="services" value="moto" />
                                </div>
                            </a></form>
                        </li>


                        <!-- //////////////////// COACH /////////////////////////// -->


                        <li>
                            <form id="form-coach" action="transfer-services-class.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-coach').submit();" title="<?php echo _('Select Coach Transfer'); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/bigger/bus.png" alt="<?php echo _('Coach'); ?>" title="<?php echo _('Coach'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Coach'); ?></p>-->

                                            <p></p>
                                            <h5><strong><?php echo _("Coach"); ?></strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 90</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 90</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('FM Radio'); ?>"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Stereo CD/MP3'); ?>"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Air Conditioning'); ?>"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Phone Charger'); ?>"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Bottle of Water'); ?>"><i class="fa fa-glass"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Wifi'); ?>"><i class="fa fa-signal"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Meet and Greet'); ?>"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Terminal Pickup'); ?>"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Car with Driver'); ?>"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $coach; ?>€</span><br /><!--<span><?php echo _('Coach'); ?></span>-->
                                        <p class="booking-item-flight-class"><br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $coach; ?>" />
                                    <input type="hidden" name="services" value="coach" />
                                </div>
                            </a></form>
                        </li>
                        
                       
                        <li>
                        </li>
                    </ul>

            </div>
            <div class="gap"></div>
        </div>


            <?php include '../footer.php'; ?>

        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/slimmenu.js"></script>
        <script src="../js/bootstrap-datepicker.js"></script>
        <script src="../js/bootstrap-timepicker.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script src="../js/dropit.js"></script>
        <script src="../js/ionrangeslider.js"></script>
        <script src="../js/icheck.js"></script>
        <script src="../js/fotorama.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&language=en"></script>
        <script src="../calcul-itineraire/functions.js"></script>
        <script src="../calcul-itineraire/autocomplete.js"></script>
        <script src="../js/typeahead.js"></script>
        <script src="../js/card-payment.js"></script>
        <script src="../js/magnific.js"></script>
        <script src="../js/owl-carousel.js"></script>
        <script src="../js/fitvids.js"></script>
        <script src="../js/tweet.js"></script>
        <script src="../js/countdown.js"></script>
        <script src="../js/gridrotator.js"></script>
        <script src="../js/custom.js"></script>
    </div>
</body>

</html>


