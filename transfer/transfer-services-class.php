<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

include '../config.php';

require "localization.php";

if (isset($_POST["transfer-services"]) || isset($_POST["services"])) {
$origin = $_POST['origin'];
$destination = $_POST['destination'];
$pickupdate = $_POST['pickupdate'];
$pickuptime = $_POST['pickuptime'];

if (!empty($_POST["returndate"]) && !empty($_POST["returntime"]) ) {
$returndate = $_POST['returndate'];
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

/* ----------------------- CHANGE IMGS FOR MOTO AND COACH -------------------------------------- */
if (isset($_POST["services"])) {
    if($_POST["services"] == 'ecocar') { $services = 'ecocar';
    $servicename =  _('Sedan Economy');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';  }
    if($_POST["services"] == 'ecovan') { $services = 'ecovan';
    $servicename =  _('Van Economy');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>'; }
    if($_POST["services"] == 'buscar') { $services = 'buscar';
    $servicename =  _('Sedan Business');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>'; }
    if($_POST["services"] == 'busvan') { $services = 'busvan';
    $servicename =  _('Van Business');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>'; }
    if($_POST["services"] == 'luxcar') { $services = 'luxcar';
    $servicename =  _('Sedan Luxury');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>'; }
    if($_POST["services"] == 'moto') { $services = 'moto';
    $servicename =  _('Motorcycle');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>'; }
    if($_POST["services"] == 'coach') { $services = 'coach';
    $servicename =  _('Coach');
    $servicesimg = '<img src="../img/cars/profile.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>'; }
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $pickupdate = $_POST['pickupdate'];
    $pickuptime = $_POST['pickuptime'];
}

if(isset($_POST['selectbrand'])) {

    $brand = $_POST['brand'];

    $selectbrand = " WHERE driver_vehicles." . $services . " LIKE  '%" . $brand."%'  ";
} else {
    $selectbrand = " ";
}


///////////////////////////////////// PAGINATION ////////////////////////////////////////

$messagesParPage=30; //Nous allons afficher 5 messages par page.


//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=$bdd->query("SELECT driver_vehicles." . $services . " AS vehiclesservices,
                            chauffeurs.company AS chauffeurscompany,
                            chauffeurs.city AS chauffeurscity,
                            driver_seats." . $services . " AS seatsservices,
                            driver_prices." . $services . " AS pricesservices,
                            driver_prices.minimum_" . $services . " AS pricesminimumservices,
                            driver_prices.disposal_" . $services . " AS pricesdisposalservices,
                            driver_prices.driverid AS pricesdriverid,
                            driver_payment.cash AS paymentcash,
                            driver_luggage." . $services . " AS luggageservices,
                            COUNT(*) AS total
                        FROM chauffeurs
                        INNER JOIN driver_vehicles ON driver_vehicles.driverid = chauffeurs.id
                        INNER JOIN driver_seats ON driver_seats.driverid = chauffeurs.id
                        INNER JOIN driver_prices ON driver_prices.driverid = driver_seats.driverid
                        INNER JOIN driver_payment ON driver_payment.driverid = driver_prices.driverid
                        INNER JOIN driver_luggage ON driver_payment.driverid = driver_luggage.driverid
                        WHERE driver_prices." . $services."<>0 ORDER BY driver_prices." . $services." ASC");
$retour_total->setFetchMode(PDO::FETCH_OBJ); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total = $retour_total->fetch(); //On range retour sous la forme d'un tableau.
$total=$donnees_total->total; //On récupère le total pour le placer dans la variable $total.

//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);

     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _("Select your Driver"); ?></title>


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

        <!-- Including jQuery and rating plugin -->
        <script type="text/javascript" src="../rating/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../rating/js/jquery.5stars.min.js"></script>

        <!-- Starting rating plugin -->
        <script type="text/javascript">
            $(document).ready(function(){

    //start plugin
                $(".stars").rating({
                    php : '../rating/admin/php/manager.php',    //path to manager.php file relative to HTML document. Not required in Display-only and Database-free modes.
                    skin    : '../rating/skins/sticker_white.png | ../rating/skins/sticker_blue.png',      //path to skin file relative to HTML document
                    displaymode    : false,      //if true - no database reqired, values will be taken from html

                    textminvotes    : '%r votes required',      //if number of votes is less then minvotes this text will be shown
                    textmain          : "<span style='color:red;'>%ms</span> / %maxs <span class='code'>(%v <?php echo _('votes'); ?>)</span>",
                    debug             : false,      //if true - debug mode will be enabled

                    onclick            : onclick      //triggers then user voted
                });

      });

            function onclick(value){
                //your code here
                //alert('on click: '+value+'%');
            }


        </script>



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

            <h3 class="booking-title"><?php echo _("Select your"); ?> <?php echo _("driver"); ?></h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="booking-item-dates-change mb30">
                        <form class="input-daterange" data-date-format="d M yyyy" action="transfer-services-class.php" method="post">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label><?php echo _("From"); ?></label>
                                <input class="typeahead form-control" value="<?php echo $origin; ?>" placeholder="<?php echo _('City or Airport'); ?>" type="text" name="origin" id="origin" onclick="initializetransfer()" onFocus="geolocate()"  />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Pick-Up Date"); ?></label>
                                        <input class="form-control" value="<?php if (!empty($pickupdate)) { echo $pickupdate; } else { echo ""; } ?>" name="pickupdate" type="text" />
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
                            <?php if (!empty($returndate) && !empty($returntime)) { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Return Date"); ?></label>
                                        <input class="form-control" value="<?php if (!empty($returndate)) { echo $returndate; } else { echo ""; } ?>" name="returndate" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo _("Return Time"); ?></label>
                                        <input class="time-pick form-control" value="<?php if (!empty($returntime)) { echo $returntime; } else { echo $current_time; } ?>" name="returntime" type="text" />
                                    </div>
                                </div>
                            </div> <?php } else { echo ""; } ?>

                                 <?php if (isset($_POST["transfer-services"]) || isset($_POST["services"])) {
                                        $from = $origin;
                                $to = $destination;

                                $pickupdate = date("d M Y", strtotime($pickupdate));
                                 $pickuptime = date("H:i", strtotime($pickuptime));

                                if (!empty($returndate) && !empty($returntime) ) {
                                $returndate = date("d M Y", strtotime($returndate));
                                 $returntime = date("H:i", strtotime($returntime));
                                 }



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


                                ?>

                                <div class="form-group form-group-icon-left">
                                        <label><?php echo _('Distance'); ?>: <?php echo $distance; ?> <?php echo _('km'); ?></label>
                                        <label><?php echo _('Duration'); ?>: <?php echo $time; ?> <?php echo _('mins'); ?></label>
                                </div>
                                <?php } else { echo ""; } ?>
                                    <input type="hidden" name="services" value="<?php echo $services; ?>" />
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
                  <!-- <div id="selectbrand">
                    <form  action="transfer-services-class.php" method="post" class="main-header-search">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>
                                <input type="hidden" name="services" value="<?php echo $services; ?>" />
                                <div class="form-group form-group-icon-left">
                                    <i class="fa fa-search input-icon"></i>
                                    <select name="brand" class="form-control input-sm">
                                    <option value=" "><?php echo _("Select brand"); ?></option>

                                                <option value="Audi">Audi</option>


                                                <option value="BMW">BMW</option>

                                                <option value="Citroen">Citroen</option>

                                                <option value="FIAT">FIAT</option>

                                                <option value="Ford">Ford</option>

                                                <option value="Hyundai">Hyundai</option>

                                                <option value="Mercedes">Mercedes-Benz</option>

                                                <option value="Nissan">Nissan</option>

                                                <option value="Peugeot">Peugeot</option>

                                                <option value="Renault">Renault</option>

                                                <option value="Skoda">Skoda</option>

                                                <option value="Volkswagen">Volkswagen</option>
                                        <option value=" "><?php echo _("All brands"); ?></option>

                                    </select>
                                    <input type="submit" class="btn btn-primary btn-xs" name="selectbrand" value="<?php echo _('OK'); ?>" />
                                </div>
                            </form>
                        </div> -->

                    <div class="nav-drop booking-sort">




                    </div>
                    <ul class="booking-list">
                        <?php

                        /* SELECT *
                        FROM driver_vehicles AS dveh, chauffeurs AS cha, driver_luggage AS dlug, driver_prices AS dpri, driver_payment AS dpay
                        WHERE dveh.driverid = cha.id = dlug.driverid = dpri.driverid = dpay.driverid
                        AND dveh.\'' . $services . '\' = dlug.\'' . $services . '\' = dpri.\'' . $services . '\'
                        ORDER BY coldate DESC */

                        // WHERE '".$origin."' LIKE CONCAT('%',chauffeurs.city,'%')"
                        $city = 'Paris, Courbevoie';
                        //$origin = '165 Boulevard Haussmann, Paris, France';
                       // WHERE '".$origin."' LIKE '%".$city."%'");
                         $field=explode(', ', $origin);
                         $subquery = "(SELECT '".implode(" AS aword UNION SELECT ", $field)."' AS aword)";
                         // (select 165 Boulevard Haussmann Paris France AS aword UNION SELECT AS aword)
                         //$sql = "SELECT * FROM table INNER JOIN $subquery sub1 ON FIND_IN_SET(sub1.aword, table.Column)";
                         // INNER JOIN ".$subquery." sub1 ON FIND_IN_SET(sub1.aword, chauffeurs.city)
                         // WHERE '".$origin."' LIKE CONCAT('%',chauffeurs.city,'%') AND driver_prices." . $services."<>0 ORDER BY driver_prices." . $serviceszz

                        $resultats=$bdd->query("SELECT driver_vehicles." . $services . " AS vehiclesservices,
                            chauffeurs.company AS chauffeurscompany,
                            chauffeurs.city AS chauffeurscity,
                            driver_seats." . $services . " AS seatsservices,
                            driver_prices." . $services . " AS pricesservices,
                            driver_prices.minimum_" . $services . " AS pricesminimumservices,
                            driver_prices.driverid AS pricesdriverid,
                            driver_payment.cash AS paymentcash,
                            driver_luggage." . $services . " AS luggageservices
                        FROM chauffeurs

                        INNER JOIN driver_vehicles ON driver_vehicles.driverid = chauffeurs.id
                        INNER JOIN driver_seats ON driver_seats.driverid = chauffeurs.id
                        INNER JOIN driver_prices ON driver_prices.driverid = driver_seats.driverid
                        INNER JOIN driver_payment ON driver_payment.driverid = driver_prices.driverid
                        INNER JOIN driver_luggage ON driver_payment.driverid = driver_luggage.driverid
                        WHERE  driver_prices." . $services . "<>0 ORDER BY driver_prices.".$services." ASC");
                      $resultats->setFetchMode(PDO::FETCH_OBJ);


                      while( $resultat = $resultats->fetch() ) { ?>



                      <li>
                            <form id="form-<?php echo $resultat->pricesdriverid; ?>" action="transfer-confirmation.php" method="post">
                                <input type="hidden" name="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <?php   } ?>

                                <a class="booking-item" href="#" onclick="document.getElementById('form-<?php echo $resultat->pricesdriverid; ?>').submit();" title="<?php _('Select Transfer'); ?>">

                                <div class="row">
                                    <div class="col-md-3 services-class-img">
                                        <div class="booking-item-car-img">

                                            <?php



                            $chauffeursid = $resultat->pricesdriverid;
                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                echo '<img class="" src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 echo $servicesimg;

                                }



                                             ?>
                                            <h5><strong><li><?php echo $resultat->chauffeurscompany; ?></li></strong></h5>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Passengers'); ?>"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x <?php echo $resultat->seatsservices; ?></span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="<?php echo _('Baggage Quantity'); ?>"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x <?php echo $resultat->luggageservices; ?></span>
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
                                    </div><?php $pricesservices = round($distance*$resultat->pricesservices);
                                                $pricesminimumservices = $resultat->pricesminimumservices; ?>
                                    <div class="col-md-3"><span class="booking-item-price"><?php if($pricesservices < $pricesminimumservices){ echo $pricesminimumservices; } else { echo $pricesservices; } ?>€ </span><br /><span><?php echo nl2br($resultat->vehiclesservices); ?></span><br />
                                        <p class="booking-item-flight-class"> <br /></p><span class="btn btn-primary"><?php echo _('Select'); ?></span>
                                    </div>
                                    <?php
                                    $sth = $bdd->prepare("SELECT * FROM rating_summary WHERE id = :chauffeursid");
                                    $sth->execute(array(':chauffeursid' => $chauffeursid));
                                    $result = $sth->fetch(PDO::FETCH_OBJ);
                                    $sth->closeCursor();
                                    $votes = $result->votes;
                                    $value = $result->mean;
                                    ?>
                                     <div class="stars " data-value="<?php echo $value; ?>" data-votes="<?php echo $votes; ?>" data-displaymode="true"></div>
                                    <input type="hidden" name="price" value="<?php if($pricesservices < $pricesminimumservices){ echo $pricesminimumservices; } else { echo $pricesservices; } ?>" />
                                    <input type="hidden" name="seats" value="<?php echo $resultat->seatsservices; ?>" />
                                    <input type="hidden" name="luggage" value="<?php echo $resultat->luggageservices; ?>" />
                                    <input type="hidden" name="services" value="<?php echo $services; ?>" />
                                    <input type="hidden" name="chauffeursid" value="<?php echo $resultat->pricesdriverid; ?>" />
                                    <?php if(isset($brand)) { ?>
                                        <input type="hidden" name="brand" value="<?php echo $brand; ?>" />
                                    <?php } ?>
                                    <input type="hidden" name="vehicles" value="<?php echo nl2br($resultat->vehiclesservices); ?>" />
                                </div>
                            </a></form>

                        </li>


                      <?php }
                              $resultats->closeCursor(); ?>


                    </ul>
                    <?php
                    echo '<p align="center">'; //Pour l'affichage, on centre la liste des pages
                              //if($nombreDePages>9) {$nombreDePages=9;} // si on a juste les chiffres qui s'affichent ///////


                             // if($nombreDePages>$nombreDePagesMax){ echo ' ...<a href="#">Booking History</a>'; }

                                if($pageActuelle > 1 && $pageActuelle <= $nombreDePages){
                                    $precedent = $pageActuelle-1;
                                    echo '<a href="'.$thispage.'?page=1" /> << </a> - ';
                                    echo '<a href="'.$thispage.'?page='.$precedent.'" /> '.$precedent.' </a> - ';
                                }

                                for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                              {
                                   //On va faire notre condition
                                   if($i==$pageActuelle) //Si il s'agit de la page actuelle...
                                   {
                                       echo '[ '.$i.' ] ';
                                   }
                                   /*else
                                   {
                                        echo ' <a href="transfers.php?page='.$i.'">'.$i.'</a> ';
                                   }*/
                              }
                                if($pageActuelle >= 1 && $pageActuelle <= $nombreDePages-1){
                                    $suivant = $pageActuelle+1;
                                    echo ' - <a href="'.$thispage.'?page='.$suivant.'" />'.$suivant.' </a> ';
                                    echo ' - <a href="'.$thispage.'?page='.$nombreDePages.'" /> >> </a>';
                                }
                         echo '</p>';

                              ?>

            </div>
            <div class="gap"></div>
        </div>


            <?php include '../footer.php'; ?>

        <!--<script src="../js/jquery.js"></script>-->
        <script src="../js/bootstrap.js"></script>
        <script src="../js/slimmenu.js"></script>
        <script src="../js/bootstrap-datepicker.js"></script>
        <script src="../js/bootstrap-timepicker.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script src="../js/dropit.js"></script>
        <script src="../js/ionrangeslider.js"></script>
        <script src="../js/icheck.js"></script>
        <script src="../js/fotorama.js"></script>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSi6rDHVg&libraries=places&language=en"></script>
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
