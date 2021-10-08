<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

include '../config.php';

require "localization.php";

if (!empty($_POST["origin"]) && !empty($_POST["destination"]) ) {

    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $pickupdate = $_POST['pickupdate'];
    $pickuptime = $_POST['pickuptime'];
    $price = $_POST['price'];
    $services = $_POST['services'];
    $vehicles = $_POST['vehicles'];
    $seats = $_POST['seats'];
    $luggage = $_POST['luggage'];
    $chauffeursid = $_POST['chauffeursid'];


        if (!empty($_POST["returndate"]) && !empty($_POST["returntime"])) {
            $returndate = $_POST['returndate'];
            $returntime = $_POST['returntime'];
            $totalprice=$price*2;
        }

}

/* ----------------------- CHANGE IMGS FOR MOTO AND COACH -------------------------------------- */
if (isset($_POST["services"])) {
    if($_POST["services"] == 'ecocar') { $servicesname = _('Sedan Economy');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/peugeot508.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }
    if($_POST["services"] == 'ecovan') { $servicesname = _('Van Economy');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/caravelle.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }
    if($_POST["services"] == 'buscar') { $servicesname = _('Sedan Business');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/mbeclass.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }
    if($_POST["services"] == 'busvan') { $servicesname = _('Van Business');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/mbviano.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }
    if($_POST["services"] == 'luxcar') { $servicesname = _('Sedan Luxury');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/mbsclass.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }
    if($_POST["services"] == 'moto') { $servicesname = _('Motorcycle');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/bigger/moto.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }
    if($_POST["services"] == 'coach') { $servicesname = _('Coach');


                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :chauffeursid');
                              $req->execute(array(
                                'chauffeursid'=>$chauffeursid
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                $servicesimg = '<img src="../driver/'.$data['up_filename'].'" alt="'.$data['up_description'].'" title="'.$data['up_title'].'" />';
                              }


                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                 $servicesimg = '<img src="../img/cars/bigger/bus.png" alt="'.$servicename.'" title="'.$servicename.'" /><p></p>';

                                }

     }

}

if(isset($_POST['brand'])) {

    $brand = $_POST['brand'];

}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php _("Confirm Transfer"); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php _('Confirm Transfer'); ?>" />
    <meta name="description" content="<?php _('Confirm Transfer'); ?>">
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

    #map{width:660px;height:260px;}
  </style>


</head>

<body>


    <div class="global-wrap">

        <?php include '../header_transfers.php'; ?>




        <div class="container">
            <ul class="breadcrumb">
                <li><a action="#" style="cursor:pointer;" onclick="gooBack()"><?php echo _("Home"); ?></a>
                </li>
                <li><a action="#" style="cursor:pointer;" onclick="goBack()"><?php echo _("Transfer Services"); ?></a>
                </li>
                <li class="active"><?php echo $servicesname; ?></li>
            </ul>
            <div class="booking-item-details">

                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em"><?php echo $servicesname; ?></h2>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><small></small>  <span class="text-lg"><?php echo $price; ?>€</span>/<?php echo _("way"); ?></p>
                        </div>
                    </div>
                </header>
                <div class="gap gap-small"></div>
                <div class="row row-wrap">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-5 reservation-confirmation-img">
                                <?php echo $servicesimg; ?>
                            </div>
                            <div class="col-md-7">
                                <div class="booking-item-price-calc">
                                    <div class="row row-wrap">
                                        <div class="col-md-6">
                                            <div class="checkbox">

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <form id="<?php echo $services; ?>form" action="transfer-payment-unregistered.php" method="post">

                                            <ul class="list">
                                                <li>
                                                    <p><?php echo _("One-way"); ?> <span><?php echo $price; ?>€</span>
                                                    </p>
                                                </li>
                                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                                <li>
                                                    <p><?php echo _("Round-Trip"); ?> <span><?php echo $totalprice; ?>€</span>
                                                    </p>
                                                </li>
                                                <?php   } ?>
                                                 <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                                <li>
                                                    <p><?php echo _("Total"); ?> <span><span id="car-total" data-value="140"><?php echo $totalprice; ?>€</span></span>
                                                    </p>
                                                </li>
                                                <?php   } else {  ?>
                                                <li>
                                                    <p><?php echo _("Total"); ?> <span><span id="car-total" data-value="140"><?php echo $price; ?>€</span></span>
                                                    </p>
                                                </li>
                                                <?php   }   ?>
                                            </ul>
                                <input type="hidden" name="origin" id="origin" value="<?php echo $origin; ?>" />
                                <input type="hidden" name="destination" id="destination" value="<?php echo $destination; ?>" />
                                <input type="hidden" name="services" id="services" value="<?php echo $services; ?>" />
                                <input type="hidden" name="vehicles" id="vehicles" value="<?php echo $vehicles; ?>" />
                                <input type="hidden" name="seats" id="seats" value="<?php echo $seats; ?>" />
                                <input type="hidden" name="luggage" id="luggage" value="<?php echo $luggage; ?>" />
                                <input type="hidden" name="chauffeursid" id="chauffeursid" value="<?php echo $chauffeursid; ?>" />
                                <input type="hidden" name="pickupdate" value="<?php echo $pickupdate; ?>" />
                                <input type="hidden" name="pickuptime" value="<?php echo $pickuptime; ?>" />
                                <input type="hidden" name="amount" value="<?php echo $price; ?>" />
                                <input type="hidden" name="return" value="https://www.hopdriver.com/">
                                <input type="hidden" name="item_name" id="item_name" value="Transfer - <?php echo $servicesname; ?>">

                               <?php

                        if(isset($_POST['brand'])) {
                               $vehicles_exploded = explode(",",$vehicles);
                                        foreach ($vehicles_exploded as $vehicle) {
                                            if (strpos($vehicle,$brand) !== false) { ?>
                                                <input type="hidden" name="vehicle" value="<?php echo $vehicle; ?>" />
                                          <?php  }
                                        }

                        } // end if isset post brand

                                        ?>
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                <input type="hidden" name="returndate" value="<?php echo $returndate; ?>" />
                                <input type="hidden" name="returntime" value="<?php echo $returntime; ?>" />
                                <input type="hidden" name="totalprice" value="<?php echo $totalprice; ?>" />
                                <?php   } ?>
                                            <button id="ecocar" name="checkout" class="btn btn-primary"><?php echo _("Book"); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                <div class="gap gap-small"></div>
                <div class="gap gap-small"></div>



                            <?php
                            $sth = $bdd->prepare("SELECT * FROM chauffeurs WHERE id = :chauffeursid");
                            $sth->execute(array(':chauffeursid' => $chauffeursid));
                            $result = $sth->fetch(PDO::FETCH_OBJ);
                            $sth->closeCursor();
                            $city =  $result->city;
                            $first_name =  $result->first_name;
                            $last_name =  $result->last_name;
                            $description = $result->vehicles;
                            $languages =  $result->languages;
                            $country =  $result->country;
                            $company =  $result->company;

                            ?>
                            <h3><?php if(!empty($company)){ echo $company; } else { echo $first_name." ".$last_name; } ?><?php if(!empty($city)){ echo ", ".$city; } ?></h3>
                            <p class="text-big"> <?php echo $description; ?> </p>

                            <div class="gap gap-small"></div>
                         <div id="map">
                            <p><?php echo _("Loading itinerary..."); ?></p>
                        </div>

                       <?php
                            $sth = $bdd->prepare("SELECT * FROM driver_payment WHERE driverid = :chauffeursid");
                            $sth->execute(array(':chauffeursid' => $chauffeursid));
                            $result = $sth->fetch(PDO::FETCH_OBJ);
                            $sth->closeCursor();
                            $cash = $result->cash;
                            $card = $result->card;
                            $water = $result->water;
                            $wifi = $result->wifi;
                            $magazines = $result->magazines;
                            ?>

                        <hr>
                        <div class="row row-wrap">
                            <div class="col-md-4">
                                <h5><?php echo _("Car Features"); ?></h5>
                                <ul class="booking-item-features booking-item-features-expand clearfix">
                                    <li><i class="fa fa-male"></i><span class="booking-item-feature-title"><?php echo _("Up to"); ?> <?php echo $seats; ?> <?php echo _("Passengers"); ?></span>
                                    </li>
                                    <li><i class="fa fa-briefcase"></i><span class="booking-item-feature-title"><?php echo $luggage; ?> <?php echo _("Suitcases"); ?></span>
                                    </li>
                                    <li><i class="fa fa-bolt"></i><span class="booking-item-feature-title"><?php echo _("Phone Charger"); ?></span>
                                    </li>
                                    <?php if($water == 1) { ?>
                                    <li><i class="fa fa-glass"></i><span class="booking-item-feature-title"><?php echo _("Bottle of Water"); ?></span>
                                    </li> <?php } ?>
                                    <?php if($wifi == 1) { ?>
                                    <li><i class="fa fa-signal"></i><span class="booking-item-feature-title"><?php echo _("Wifi"); ?></span>
                                    </li> <?php } ?>
                                    <?php if($magazines == 1) { ?>
                                    <li><i class="fa fa-book"></i><span class="booking-item-feature-title"><?php echo _("Magazines"); ?></span>
                                    </li> <?php } ?>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h5><?php echo _("Default Equipment"); ?></h5>
                                <ul class="booking-item-features booking-item-features-expand clearfix">
                                    <li><i class="im im-climate-control"></i><span class="booking-item-feature-title"><?php echo _("Climate Control"); ?></span>
                                    </li>
                                    <li><i class="im im-air"></i><span class="booking-item-feature-title"><?php echo _("Air Conditioning"); ?></span>
                                    </li>
                                    <li><i class="im im-stereo"></i><span class="booking-item-feature-title"><?php echo _("Stereo CD/MP3"); ?></span>
                                    </li>
                                    <li><i class="im im-fm"></i><span class="booking-item-feature-title"><?php echo _("FM Radio"); ?></span>
                                    </li>
                                    <li><i class="im im-lock"></i><span class="booking-item-feature-title"><?php echo _("Power Door Locks"); ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h5><?php echo _("Accepted Payment Onboard"); ?></h5>
                                <ul class="booking-item-features booking-item-features-expand clearfix">
                                    <?php if($card == 1) { ?>
                                    <li><i class="fa fa-credit-card"></i><span class="booking-item-feature-title"><?php echo _("Credit Card"); ?></span>
                                    </li> <?php } ?>
                                    <?php if($cash == 1) { ?>
                                    <li><i class="fa fa-money"></i><span class="booking-item-feature-title"><?php echo _("Cash"); ?></span>
                                    </li> <?php } ?>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h5><?php echo _("Pickup Features"); ?></h5>
                                <ul class="booking-item-features booking-item-features-expand booking-item-features-dark clearfix">
                                    <li><i class="fa fa-plane"></i><span class="booking-item-feature-title"><?php echo _("Terminal Pickup"); ?></span>
                                    </li>
                                    <li><i class="im im-meet"></i><span class="booking-item-feature-title"><?php echo _("Meet and Greet"); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="booking-item-deails-date-location">
                            <ul>
                                <li>
                                    <h5><?php echo _("Pick Up"); ?>:</h5>
                                    <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i><?php echo $origin; ?></p>
                                    <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i><?php echo $pickupdate; ?></p>
                                    <p><i class="fa fa-clock-o box-icon-inline box-icon-gray"></i><?php echo $pickuptime; ?></p>
                                </li>
                                <li>
                                    <h5><?php echo _("Drop Off"); ?>:</h5>
                                    <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i><?php echo $destination; ?></p>

                                </li>
                                <li>
                                    <h5><?php echo _("Return"); ?>:</h5>
                                    <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                    <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i><?php echo $returndate; ?></p>
                                    <p><i class="fa fa-clock-o box-icon-inline box-icon-gray"></i><?php echo $returntime; ?></p>
                                    <?php } else { echo ""; } ?>

                                </li>
                                <li>
                                    <h5><?php echo _("Vehicles"); ?>:</h5>
                                    <p><i class="fa fa-car box-icon-inline box-icon-gray"></i>


                                        <?php

                                if(isset($_POST['brand'])) {

                                        $vehicles_exploded = explode(",",$vehicles);
                                        foreach ($vehicles_exploded as $vehicle) {
                                            if (strpos($vehicle,$brand) !== false) {
                                                echo $vehicle;
                                            }
                                        }

                                 } // end if isset post brand
                                else { echo $vehicles; }


                                    ?></p>
                                </li>
                                <li>
                                    <h5><?php echo _("Spoken Langues"); ?>:</h5>
                                    <p><i class="fa fa-comments box-icon-inline box-icon-gray"></i>


                                        <?php  echo $languages;


                                    ?></p>
                                </li>
                            </ul>

                        </div>
                        <div class="gap gap-small"></div>
                    </div>
                </div>
            </div>
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
        <script src="../js/typeahead.js"></script>
        <script src="../js/card-payment.js"></script>
        <script src="../js/magnific.js"></script>
        <script src="../js/owl-carousel.js"></script>
        <script src="../js/fitvids.js"></script>
        <script src="../js/tweet.js"></script>
        <script src="../js/countdown.js"></script>
        <script src="../js/gridrotator.js"></script>
        <script src="../js/custom.js"></script>
        <script>
        function goBack() {
            window.history.back()
        }
        function gooBack() {
            window.history.go(-3)
        }
        </script>
        <script>
            window.addEventListener("DOMContentLoaded", function () {
              var form = document.getElementById("ecocarform");

            document.getElementById("ecocar").addEventListener("click", function () {
              form.submit();
            });
        </script>
    </div>
</body>

</html>
