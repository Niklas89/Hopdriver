<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

include '../config.php';

require "localization.php";



if (isset($_POST["disposal-cars"])) {
$pick_up_loc = $_POST['pick_up_loc'];
$drop_off_loc = $_POST['drop_off_loc'];
$pickupdate = $_POST['start'];
$pickuptime = $_POST['pickuptime'];
$drop_off_date = $_POST['end'];
$drop_off_time = $_POST['dropofftime'];
$hoursday = $_POST['hoursday'];

}else {
    $pick_up_loc = "CDG Charles De Gaulle Airport, Roissy-en-France, France";
    $drop_off_loc = "3 Rue Caulaincourt, 75018 Paris, France";
    date_default_timezone_set('Europe/Madrid');
    $pickupdate = date('d M Y');
    $pickuptime = date('H:i');
    $drop_off_date = date('d M Y',strtotime("+1 week"));
    $drop_off_time = date('H:i');
    $hoursday = 10;
}

date_default_timezone_set('Europe/Madrid');
      $current_time = date('H:i');

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _("Disposal Services"); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('Disposal Services'); ?>" />
    <meta name="description" content="<?php echo _('Disposal Services'); ?>">
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

        <?php include '../header_disposals.php'; ?>


        <div class="container">
            <ul class="breadcrumb">
                <li><a action="../index.php" title="<?php echo _('Previous'); ?>"><?php echo _("Home"); ?></a>
                </li> <!--
                <li><a href="#">France</a>
                </li>
                <li><a href="#">Paris</a>
                </li> -->
                <li class="active"><?php echo _("Disposal Services"); ?></li>
            </ul>

            <h3 class="booking-title"><?php echo _("Select your category"); ?></h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="booking-item-dates-change mb30">
                        <form class="input-daterange" data-date-format="d M yyyy" action="disposal-cars.php" method="post">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label><?php echo _("Pick-Up Location"); ?></label>
                                <input class="typeahead form-control" value="<?php echo $pick_up_loc; ?>" placeholder="<?php echo _('City or Airport'); ?>" type="text" name="pick_up_loc" id="origin" onclick="initializetransfer()" onFocus="geolocate()" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Pick-Up Date"); ?></label>
                                        <input class="form-control" value="<?php if (!empty($_POST["start"])) { echo $pickupdate; } else { echo ""; } ?>" name="start" type="text" />
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
                                <label><?php echo _("Drop-Off Location"); ?></label>
                                <input class="typeahead form-control" value="<?php echo $drop_off_loc; ?>" placeholder="<?php echo _('City or Airport'); ?>" type="text"  name="drop_off_loc" id="destination" onclick="initializetransferto()" onFocus="geolocate()" />
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Drop-Off Date"); ?></label>
                                        <input class="form-control" value="<?php if (!empty($_POST["end"])) { echo $drop_off_date; } else { echo ""; } ?>" name="end" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Drop-Off Time"); ?></label>
                                        <input class="time-pick form-control" value="<?php if (!empty($_POST["dropofftime"])) { echo $drop_off_time; } else { echo $current_time; } ?>" name="dropofftime" type="text" />
                                    </div>
                                </div>
                            </div>

                                 <?php if (isset($_POST["disposal-cars"])) {


                                $from = urlencode($pick_up_loc);
                                $to = urlencode($drop_off_loc);
                                $pickupdate = date("d M Y", strtotime($_POST["start"]));
                                $pickuptime = date("H:i", strtotime($pickuptime));
                                $drop_off_date = date("d M Y", strtotime($_POST["end"]));
                                 $drop_off_time = date("H:i", strtotime($drop_off_time));
                                $datediff = strtotime($drop_off_date) - strtotime($pickupdate);
                                $datedifff = floor($datediff/(60*60*24));

                                $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=driving&language=en-EN&sensor=true");
                                $data = json_decode($data);

                                $time = 0;
                                $distance = 0;

                                foreach($data->rows[0]->elements as $road) {
                                    $time += $road->duration->text;
                                    $distance += $road->distance->text;
                                }

                                 $sth = $bdd->prepare("SELECT MIN(NULLIF(disposal_ecocar, 0)) AS disposalecocar,
                                         MIN(NULLIF(disposal_ecovan, 0)) AS disposalecovan,
                                          MIN(NULLIF(disposal_buscar, 0)) AS disposalbuscar,
                                           MIN(NULLIF(disposal_busvan, 0)) AS disposalbusvan,
                                            MIN(NULLIF(disposal_luxcar, 0)) AS disposalluxcar,
                                             MIN(NULLIF(disposal_moto, 0)) AS disposalmoto,
                                              MIN(NULLIF(disposal_coach, 0)) AS disposalcoach
                                      FROM driver_prices ");
                                        $sth->execute();
                                        $result = $sth->fetch(PDO::FETCH_OBJ);
                                        $sth->closeCursor();
                                        $economycar = $result->disposalecocar;
                                        $economyvan = $result->disposalecovan;
                                        $businesscar = $result->disposalbuscar;
                                        $businessvan = $result->disposalbusvan;
                                        $luxurycar = $result->disposalluxcar;
                                        $motorcycle = $result->disposalmoto;
                                        $coach = $result->disposalcoach;




                                $totalhours = $datedifff*$hoursday;
                                $totaleconomycar = $totalhours*$economycar;
                                $totaleconomyvan = $totalhours*$economyvan;
                                $totalbusinesscar = $totalhours*$businesscar;
                                $totalbusinessvan = $totalhours*$businessvan;
                                $totalluxurycar = $totalhours*$luxurycar;
                                $totalmotorcycle = $totalhours*$motorcycle;
                                $totalcoach = $totalhours*$coach;

                                ?>

                                <div class="form-group form-group-icon-left">
                                        <label><?php echo _('Distance'); ?>: <?php echo $distance; ?> <?php echo _('km'); ?></label>
                                        <label><?php echo _('Duration'); ?>: <?php echo $time; ?> <?php echo _('mins'); ?></label>
                                        <label><?php echo $datedifff; ?> <?php echo _('days of disposal'); ?></label>
                                        <label><?php echo $hoursday; ?> <?php echo _('hours per day'); ?></label>
                                </div>
                                <?php } else {


                                $from = urlencode($pick_up_loc);
                                $to = urlencode($drop_off_loc);
                                $pickupdatee = date("d M Y", strtotime($pickupdate));
                                $drop_off_datee = date("d M Y", strtotime($drop_off_date));
                                $datediff = strtotime($drop_off_datee) - strtotime($pickupdatee);
                                $datedifff = floor($datediff/(60*60*24));

                                $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=driving&language=en-EN&sensor=true");
                                $data = json_decode($data);

                                $time = 0;
                                $distance = 0;

                                foreach($data->rows[0]->elements as $road) {
                                    $time += $road->duration->text;
                                    $distance += $road->distance->text;
                                }

                                $sth = $bdd->prepare("SELECT MIN(NULLIF(disposal_ecocar, 0)) AS disposalecocar,
                                         MIN(NULLIF(disposal_ecovan, 0)) AS disposalecovan,
                                          MIN(NULLIF(disposal_buscar, 0)) AS disposalbuscar,
                                           MIN(NULLIF(disposal_busvan, 0)) AS disposalbusvan,
                                            MIN(NULLIF(disposal_luxcar, 0)) AS disposalluxcar,
                                             MIN(NULLIF(disposal_moto, 0)) AS disposalmoto,
                                              MIN(NULLIF(disposal_coach, 0)) AS disposalcoach
                                      FROM driver_prices ");
                                       $sth->execute();
                                        $result = $sth->fetch(PDO::FETCH_OBJ);
                                        $sth->closeCursor();
                                        $economycar = $result->disposalecocar;
                                        $economyvan = $result->disposalecovan;
                                        $businesscar = $result->disposalbuscar;
                                        $businessvan = $result->disposalbusvan;
                                        $luxurycar = $result->disposalluxcar;
                                        $motorcycle = $result->disposalmoto;
                                        $coach = $result->disposalcoach;





                                $totalhours = $datedifff*$hoursday;
                                $totaleconomycar = $totalhours*$economycar;
                                $totaleconomyvan = $totalhours*$economyvan;
                                $totalbusinesscar = $totalhours*$businesscar;
                                $totalbusinessvan = $totalhours*$businessvan;
                                $totalluxurycar = $totalhours*$luxurycar;
                                $totalmotorcycle = $totalhours*$motorcycle;
                                $totalcoach = $totalhours*$coach;

                                ?>

                                <div class="form-group form-group-icon-left">
                                        <label><?php echo _('Distance'); ?>: <?php echo $distance; ?> <?php echo _('km'); ?></label>
                                        <label><?php echo _('Duration'); ?>: <?php echo $time; ?> <?php echo _('mins'); ?></label>
                                        <label><?php echo $datedifff; ?> <?php echo _('days of disposal'); ?></label>
                                        <label><?php echo $hoursday; ?> <?php echo _('hours per day'); ?></label>
                                </div>
                                <?php } ?>
                                <input class="btn btn-primary" type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                            <input class="btn btn-primary" type="submit" name="disposal-cars" value="<?php echo _('Update Details'); ?>" />
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

                        <li>
                            <form id="form-ecocar" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />


                                <a class="booking-item" href="#" onclick="document.getElementById('form-ecocar').submit();" title="<?php echo _('Select Economy Disposal'); ?>">

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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $economycar; ?>€</span><span>/<?php echo _("hour"); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                        <!--<p class="booking-item-flight-class"><?php echo _('Economy Class'); ?></p>--><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $economycar; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totaleconomycar; ?>" />
                                    <input type="hidden" name="services" value="ecocar" />
                                </div>
                            </a></form>
                        </li>
                        <li>
                            <form id="form-ecovan" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />


                                <a class="booking-item" href="#" onclick="document.getElementById('form-ecovan').submit();" title="<?php echo _('Select Economy Disposal'); ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/caravelle.png" alt="<?php echo _('Economy Class'); ?>" title="<?php echo _('Economy Class'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Economy Class'); ?></p>-->

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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $businesscar; ?>€</span><span>/<?php echo _("hour"); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                        <!--<p class="booking-item-flight-class"><?php echo _('Economy Class'); ?></p>--><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $economyvan; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totaleconomyvan; ?>" />
                                    <input type="hidden" name="services" value="ecovan" />
                                </div>
                            </a></form>
                        </li>
                        <li>
                            <form id="form-id" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />

                                <a class="booking-item" href="#" onclick="document.getElementById('form-id').submit();" title="<?php echo _('Select Business Disposal'); ?>">



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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $businesscar; ?>€</span><span>/<?php echo _("hour"); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                        <!--<p class="booking-item-flight-class"><?php echo _('Business Class'); ?></p>--><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $businesscar; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totalbusinesscar; ?>" />
                                    <input type="hidden" name="services" value="buscar" />

                                </div>
                            </a></form>
                        </li>
                        <li>
                            <form id="form-idviano" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />


                                <a class="booking-item" href="#" onclick="document.getElementById('form-idviano').submit();" title="Select Business Disposal">
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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $businessvan; ?>€</span><span>/<?php echo _("hour"); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                       <!-- <p class="booking-item-flight-class"><?php echo _('Business Class'); ?></p>--><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $businessvan; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totalbusinessvan; ?>" />
                                    <input type="hidden" name="services" value="busvan" />
                                </div>
                            </a></form>
                        </li>
                        <li>
                            <form id="form-luxcar" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />


                                <a class="booking-item" href="#" onclick="document.getElementById('form-luxcar').submit();" title="<?php echo _('Select Luxury Disposal'); ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="../img/cars/mbsclass.png" alt="<?php echo _('Sedan Luxury'); ?>" title="<?php echo _('Sedan Luxury'); ?>" />
                                            <!--<p class="booking-item-car-title"><?php echo _('Luxury'); ?></p>-->

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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $luxurycar; ?>€</span><span>/<?php echo _("hour"); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                        <!--class="booking-item-flight-class"><?php echo _('Sedan Luxury'); ?></p>--><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $luxurycar; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totalluxurycar; ?>" />
                                    <input type="hidden" name="services" value="luxcar" />
                                </div>
                            </a></form>
                        </li>




                        <li>
                            <form id="form-moto" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />


                                <a class="booking-item" href="#" onclick="document.getElementById('form-moto').submit();" title="<?php echo _('Select Moto Disposal'); ?>">
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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $motorcycle; ?>€</span><span>/<?php echo _("hour"); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                        <!--<p class="booking-item-flight-class"><?php echo _('Motorcycle'); ?></p>--><span class="btn btn-primary"><?php echo _("Select"); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $motorcycle; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totalmotorcycle; ?>" />
                                    <input type="hidden" name="services" value="moto" />
                                </div>
                            </a></form>
                        </li>



                        <li>
                            <form id="form-coach" action="disposal-services-class.php" method="post">
                                <input type="hidden" name="pick_up_loc" value="<?php echo $pick_up_loc; ?>" />
                                <input type="hidden" name="drop_off_loc" value="<?php echo $drop_off_loc; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="drop_off_date" value="<?php echo $drop_off_date; ?>" />
                                <input type="hidden" name="drop_off_time" value="<?php echo $drop_off_time; ?>" />


                                <a class="booking-item" href="#" onclick="document.getElementById('form-coach').submit();" title="<?php echo _('Select Coach Disposal'); ?>">
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
                                    <div class="col-md-3"><span class="booking-item-price"><?php echo $coach; ?>€</span><span>/<?php echo _('hour'); ?></span>
                                        <p class="booking-item-flight-class"> <br /></p>
                                       <!-- <p class="booking-item-flight-class"><?php echo _('Coach'); ?></p>--><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <input type="hidden" name="price" value="<?php echo $coach; ?>" />
                                    <input type="hidden" name="hoursday" value="<?php echo $hoursday; ?>" />
                                     <input type="hidden" name="totalprice" value="<?php echo $totalcoach; ?>" />
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
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaDHVg&libraries=places&language=en"></script>
    <!-- <script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&language=en"></script> -->
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
