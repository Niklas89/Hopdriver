<?php

session_start();

$id_users = $_SESSION['id'];
 if(empty($_SESSION['id']))
 {
   header('Location: login.php');
   exit();
 }

if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

require "localization.php";



include '../config.php';

    $sth = $bdd->prepare("SELECT * FROM chauffeurs WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $first_name=$result->first_name;
        $last_name=$result->last_name;


    $sth = $bdd->prepare("SELECT * FROM driver_prices WHERE driverid = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();

        if ($result)
        {
        $location=$result->location;
        $round=$result->round;
        $price_km_ecocar = $result->ecocar;
        $price_km_ecovan = $result->ecovan;
        $price_km_buscar = $result->buscar;
        $price_km_busvan = $result->busvan;
        $price_km_luxcar = $result->luxcar;
        $price_km_moto = $result->moto;
        $price_km_coach = $result->coach;
        $price_minimum_ecocar = $result->minimum_ecocar;
        $price_minimum_ecovan = $result->minimum_ecovan;
        $price_minimum_buscar = $result->minimum_buscar;
        $price_minimum_busvan = $result->minimum_busvan;
        $price_minimum_luxcar = $result->minimum_luxcar;
        $price_minimum_moto = $result->minimum_moto;
        $price_minimum_coach = $result->minimum_coach;
        $price_disposal_ecocar = $result->disposal_ecocar;
        $price_disposal_ecovan = $result->disposal_ecovan;
        $price_disposal_buscar = $result->disposal_buscar;
        $price_disposal_busvan = $result->disposal_busvan;
        $price_disposal_luxcar = $result->disposal_luxcar;
        $price_disposal_moto = $result->disposal_moto;
        $price_disposal_coach = $result->disposal_coach;
      }




if(isset($_POST['economyclass']))  {
  if(((!empty($_POST['price_km_ecocar']) && !empty($_POST['price_minimum_ecocar']) && !empty($_POST['price_disposal_ecocar'])) ||
        (!empty($_POST['price_km_ecovan']) && !empty($_POST['price_minimum_ecovan']) && !empty($_POST['price_disposal_ecovan'])))
       && ((!empty($_POST['location']))&&(!empty($_POST['round'])))
      ) {
    //extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $ecoclass_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {
        $price_km_ecocar = $_POST['price_km_ecocar'];
        $price_minimum_ecocar = $_POST['price_minimum_ecocar'];
        $price_disposal_ecocar = $_POST['price_disposal_ecocar'];
        $price_km_ecovan = $_POST['price_km_ecovan'];
        $price_minimum_ecovan = $_POST['price_minimum_ecovan'];
        $price_disposal_ecovan = $_POST['price_disposal_ecovan'];
        $location=$_POST['location'];
        $round=$_POST['round'];


      $req = $bdd->prepare('SELECT id FROM driver_prices  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_prices (driverid,location,round,ecocar,minimum_ecocar,disposal_ecocar,ecovan,minimum_ecovan,disposal_ecovan) VALUES (:id_users,:location,:round,:price_km_ecocar,:price_minimum_ecocar,:price_disposal_ecocar,:price_km_ecovan,:price_minimum_ecovan,:price_disposal_ecovan)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'location'=>$location,
        'round'=>$round,
        'price_km_ecocar'=>$price_km_ecocar,
        'price_minimum_ecocar'=>$price_minimum_ecocar,
        'price_disposal_ecocar'=>$price_disposal_ecocar,
        'price_km_ecovan'=>$price_km_ecovan,
        'price_minimum_ecovan'=>$price_minimum_ecovan,
        'price_disposal_ecovan'=>$price_disposal_ecovan

      ));
      $reqq->closeCursor();

        $ecoclass_ok = _("Settings succesfully saved.");

    }


    else
    {
      if($req->rowCount()>0)
      {


        $req = $bdd->prepare('UPDATE driver_prices SET location=:location, round=:round , ecocar = :price_km_ecocar, minimum_ecocar = :price_minimum_ecocar, disposal_ecocar = :price_disposal_ecocar, ecovan = :price_km_ecovan,
       minimum_ecovan = :price_minimum_ecovan, disposal_ecovan = :price_disposal_ecovan
        WHERE driverid = :id_users');
      $req->execute(array(
        'location'=>$location,
        'round'=>$round,
        'price_km_ecocar'=>$price_km_ecocar,
        'price_minimum_ecocar'=>$price_minimum_ecocar,
        'price_disposal_ecocar'=>$price_disposal_ecocar,
        'price_km_ecovan'=>$price_km_ecovan,
        'price_minimum_ecovan'=>$price_minimum_ecovan,
        'price_disposal_ecovan'=>$price_disposal_ecovan,
        'id_users'=>$id_users

      ));

        $ecoclass_ok = _("Settings succesfully changed.");
      }
    }

      $req->closeCursor();




       } //end if valid
} // end if isset economyclass






if(isset($_POST['businessclass']))  {
  if(
    (!empty($_POST['price_km_buscar']) && !empty($_POST['price_minimum_buscar']) && !empty($_POST['price_disposal_buscar'])) ||
        (!empty($_POST['price_km_busvan']) && !empty($_POST['price_minimum_busvan']) && !empty($_POST['price_disposal_busvan']))
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $busclass_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $price_km_buscar = $_POST['price_km_buscar'];
        $price_minimum_buscar = $_POST['price_minimum_buscar'];
        $price_disposal_buscar = $_POST['price_disposal_buscar'];
        $price_km_busvan = $_POST['price_km_busvan'];
        $price_minimum_busvan = $_POST['price_minimum_busvan'];
        $price_disposal_busvan = $_POST['price_disposal_busvan'];






     $req = $bdd->prepare('SELECT id FROM driver_prices  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_prices (driverid,buscar,minimum_buscar,disposal_buscar,busvan,minimum_busvan,disposal_busvan) VALUES (:id_users,:price_km_buscar,:price_minimum_buscar,:price_disposal_buscar,:price_km_busvan,:price_minimum_busvan,:price_disposal_busvan)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'price_km_buscar'=>$price_km_buscar,
        'price_minimum_buscar'=>$price_minimum_buscar,
        'price_disposal_buscar'=>$price_disposal_buscar,
        'price_km_busvan'=>$price_km_busvan,
        'price_minimum_busvan'=>$price_minimum_busvan,
        'price_disposal_busvan'=>$price_disposal_busvan,

      ));
      $reqq->closeCursor();

        $busclass_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_prices SET buscar = :price_km_buscar, minimum_buscar = :price_minimum_buscar, disposal_buscar = :price_disposal_buscar, busvan = :price_km_busvan,
       minimum_busvan = :price_minimum_busvan, disposal_busvan = :price_disposal_busvan
        WHERE driverid = :id_users');
      $req->execute(array(
        'price_km_buscar'=>$price_km_buscar,
        'price_minimum_buscar'=>$price_minimum_buscar,
        'price_disposal_buscar'=>$price_disposal_buscar,
        'price_km_busvan'=>$price_km_busvan,
        'price_minimum_busvan'=>$price_minimum_busvan,
        'price_disposal_busvan'=>$price_disposal_busvan,
        'id_users'=>$id_users

      ));
        $busclass_ok = _("Settings succesfully changed.");
      }
    }

      $req->closeCursor();


       } //end if valid
} // end if isset businessclass





if(isset($_POST['luxuryclass']))  {
  if(
    !empty($_POST['price_km_luxcar']) && !empty($_POST['price_minimum_luxcar']) && !empty($_POST['price_disposal_luxcar'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $luxclass_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $price_km_luxcar = $_POST['price_km_luxcar'];
        $price_minimum_luxcar = $_POST['price_minimum_luxcar'];
        $price_disposal_luxcar = $_POST['price_disposal_luxcar'];






     $req = $bdd->prepare('SELECT id FROM driver_prices  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_prices (driverid,luxcar,minimum_luxcar,disposal_luxcar) VALUES (:id_users,:price_km_luxcar,:price_minimum_luxcar,:price_disposal_luxcar)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'price_km_luxcar'=>$price_km_luxcar,
        'price_minimum_luxcar'=>$price_minimum_luxcar,
        'price_disposal_luxcar'=>$price_disposal_luxcar,

      ));
      $reqq->closeCursor();

        $luxclass_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

         $req = $bdd->prepare('UPDATE driver_prices SET luxcar = :price_km_luxcar, minimum_luxcar = :price_minimum_luxcar, disposal_luxcar = :price_disposal_luxcar
        WHERE driverid = :id_users');
      $req->execute(array(
        'price_km_luxcar'=>$price_km_luxcar,
        'price_minimum_luxcar'=>$price_minimum_luxcar,
        'price_disposal_luxcar'=>$price_disposal_luxcar,
        'id_users'=>$id_users

      ));
        $luxclass_ok = _("Settings succesfully changed.");
      }
    }

      $req->closeCursor();


       } //end if valid
} // end if isset luxuryclass




if(isset($_POST['motorcycle']))  {
  if(
    !empty($_POST['price_km_moto']) && !empty($_POST['price_minimum_moto']) && !empty($_POST['price_disposal_moto'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $moto_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $price_km_moto = $_POST['price_km_moto'];
        $price_minimum_moto = $_POST['price_minimum_moto'];
        $price_disposal_moto = $_POST['price_disposal_moto'];







     $req = $bdd->prepare('SELECT id FROM driver_prices  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_prices (driverid,moto,minimum_moto,disposal_moto) VALUES (:id_users,:price_km_moto,:price_minimum_moto,:price_disposal_moto)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'price_km_moto'=>$price_km_moto,
        'price_minimum_moto'=>$price_minimum_moto,
        'price_disposal_moto'=>$price_disposal_moto,

      ));
      $reqq->closeCursor();

        $moto_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_prices SET moto = :price_km_moto, minimum_moto = :price_minimum_moto, disposal_moto = :price_disposal_moto
        WHERE driverid = :id_users');
      $req->execute(array(
        'price_km_moto'=>$price_km_moto,
        'price_minimum_moto'=>$price_minimum_moto,
        'price_disposal_moto'=>$price_disposal_moto,
        'id_users'=>$id_users

      ));

        $moto_ok = _("Settings succesfully changed.");
      }
    }

      $req->closeCursor();


       } //end if valid
} // end if isset motorcycle





if(isset($_POST['coach']))  {
  if(
    !empty($_POST['price_km_coach']) && !empty($_POST['price_minimum_coach']) && !empty($_POST['price_disposal_coach'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $coach_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $price_km_coach = $_POST['price_km_coach'];
        $price_minimum_coach = $_POST['price_minimum_coach'];
        $price_disposal_coach = $_POST['price_disposal_coach'];






     $req = $bdd->prepare('SELECT id FROM driver_prices  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_prices (driverid,coach,minimum_coach,disposal_coach) VALUES (:id_users,:price_km_coach,:price_minimum_coach,:price_disposal_coach)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'price_km_coach'=>$price_km_coach,
        'price_minimum_coach'=>$price_minimum_coach,
        'price_disposal_coach'=>$price_disposal_coach,

      ));
      $reqq->closeCursor();

        $coach_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_prices SET coach = :price_km_coach, minimum_coach = :price_minimum_coach, disposal_coach = :price_disposal_coach
        WHERE driverid = :id_users');
      $req->execute(array(
        'price_km_coach'=>$price_km_coach,
        'price_minimum_coach'=>$price_minimum_coach,
        'price_disposal_coach'=>$price_disposal_coach,
        'id_users'=>$id_users

      ));
        $coach_ok = _("Settings succesfully changed.");
      }
    }

      $req->closeCursor();


       } //end if valid
} // end if isset coach


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('Price Settings'); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('airport transfers, private transfer, HopDriver, disposal services'); ?>" />
    <meta name="description" content="<?php echo _('HopDriver - private transfers and disposal services'); ?>">
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


</head>

<body>


    <div class="global-wrap">

        <?php include '../header_partners.php'; ?>

        <div class="container">
            <h1 class="page-title"><?php echo _('Price Settings'); ?></h1>
        </div>




        <div class="container">
            <div class="row">



                <?php $driverfirst_name = $first_name; $driverlast_name = $last_name; ?>
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="row">


                            <h4><?php echo _('Type your price for each service'); ?></h4>


                            <!-- ERROR -->
                                                    <?php if(isset($ecoclass_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $ecoclass_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($ecoclass_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $ecoclass_erreurid; ?></p>
                                                        </div> <?php } ?>



                                                    <?php if(isset($busclass_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $busclass_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($busclass_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $busclass_erreurid; ?></p>
                                                        </div> <?php } ?>



                                                    <?php if(isset($luxclass_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $luxclass_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($luxclass_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $luxclass_erreurid; ?></p>
                                                        </div> <?php } ?>



                                                    <?php if(isset($moto_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $moto_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($moto_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $moto_erreurid; ?></p>
                                                        </div> <?php } ?>


                                                    <?php if(isset($coach_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $coach_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($coach_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $coach_erreurid; ?></p>
                                                        </div> <?php } ?>
                                                <!-- END ERROR -->






                                <div class="gap gap-small"></div>
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#tab-1" data-toggle="tab"><?php echo _('Economy Class'); ?></a>
                                    </li>
                                    <li><a href="#tab-2" data-toggle="tab"><?php echo _('Business Class'); ?></a>
                                    </li>
                                    <li><a href="#tab-3" data-toggle="tab"><?php echo _('First Class'); ?></a>
                                    </li>
                                    <li><a href="#tab-4" data-toggle="tab"><?php echo _('Motorcycle'); ?></a>
                                    </li>
                                    <li><a href="#tab-5" data-toggle="tab"><?php echo _('Coach'); ?></a>
                                    </li>
                                </ul>

                                <div class="gap gap-small"></div>
                                <div class="tab-content">



                                    <!-- ---------------------------tab-1--------------------- -->
                                    <div class="tab-pane fade in active" id="tab-1">
                                        <p class="mt10"><strong><?php echo _('Economy Sedan'); ?>:</strong> <?php echo _('standard class cars like Peugeot 508, Mercedes Benz C Class, Citroen C5, Renault Laguna or similar'); ?>.<br /> <strong><?php echo _('Economy Van'); ?>:</strong> <?php echo _('standard class vans like Volkswagen Caravelle, Mercedes-Benz Vito or similar'); ?>.</p>
                                        <div class="gap gap-small"></div>
                                        <div class="col-md-12">
                                                <form action="price-settings.php" method="post">
                                                  <div class="col-md-4">
                                                    <h4><?php echo _('Economy Sedan'); ?></h4>
                                                    <?php if(isset($ecoclass_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $ecoclass_ok; ?></p>
                                                    </div> <?php } ?>



                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_ecocar)) { echo $price_km_ecocar; } else { echo ""; } ?>" name="price_km_ecocar" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_ecocar)) { echo $price_minimum_ecocar; } else { echo ""; } ?>" name="price_minimum_ecocar" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_ecocar)) { echo $price_disposal_ecocar; } else { echo ""; } ?>" name="price_disposal_ecocar" type="text" />
                                                    </div>
                                                    <hr>

                                                    <h4><?php echo _('My Business Area'); ?></h4>
                                                    <div class="form-gsroup form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                        <label><?php echo _('Location'); ?>: <?php echo _('Location'); ?></label>

                                                        <div id="locationField">
                                                        <input id="autocompleteway" class="form-control" value="<?php if(!empty($location)){ echo $location; } else { echo "";} ?>" name="location" type="text" onclick="initialize2()"  onFocus="geolocate()" placeholder="Enter your address" />
                                                        </div>
                                                  </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-keyboard-o input-icon"></i>
                                                        <label><?php echo _('Round'); ?>: <?php echo _('Round by Km'); ?></label>
                                                        <input Type="number" class="form-control" value="<?php if(!empty($round)){ echo $round; }else { echo "";} ?>" name="round" min="1" />
                                                    </div>
                                                    <hr />
                                                    <input type="submit" class="btn btn-primary" name="economyclass" value="Save Changes">
                                                    <div class="gap gap-small"></div>

                                                  </div>
                                            <div class="col-md-4">
                                                <h4><?php echo _('Economy Van'); ?></h4>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_ecovan)) { echo $price_km_ecovan; } else { echo ""; } ?>" name="price_km_ecovan" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_ecovan)) { echo $price_minimum_ecovan; } else { echo ""; } ?>" name="price_minimum_ecovan" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_ecovan)) { echo $price_disposal_ecovan; } else { echo ""; } ?>" name="price_disposal_ecovan" type="text" />
                                                    </div>

                                                    <hr>

                                                  </div>
                                                </form>
                                            </div>
                                    </div>



                                    <!-- ---------------------------tab-2--------------------- -->
                                    <div class="tab-pane fade" id="tab-2">
                                         <p class="mt10"><strong><?php echo _('Business Sedan'); ?>:</strong> <?php echo _('business class cars like Mercedes-Benz E Class, BMW 5 Series, Audi A6 or similar'); ?>.<br /> <strong><?php echo _('Business Van'); ?>:</strong> <?php echo _('business class vans like Mercedes-Benz Viano, Mercedes-Benz Class V, Volkswagen Multivan or similar'); ?>.</p>
                                        <div class="gap gap-small"></div>
                                        <div class="col-md-4">
                                                <form action="price-settings.php" method="post">
                                                    <h4><?php echo _('Business Sedan'); ?></h4>

                                                    <?php if(isset($busclass_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $busclass_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($busclass_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $busclass_erreurid; ?></p>
                                                        </div> <?php } ?>


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_buscar)) { echo $price_km_buscar; } else { echo ""; } ?>" name="price_km_buscar" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_buscar)) { echo $price_minimum_buscar; } else { echo ""; } ?>" name="price_minimum_buscar" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_buscar)) { echo $price_disposal_buscar; } else { echo ""; } ?>" name="price_disposal_buscar" type="text" />
                                                    </div>

                                                    <div class="gap gap-small"></div>


                                                    <hr>
                                            </div>
                                            <div class="col-md-4 col-md-offset-1">
                                                <h4><?php echo _('Business Van'); ?></h4>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_busvan)) { echo $price_km_busvan; } else { echo ""; } ?>" name="price_km_busvan" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_busvan)) { echo $price_minimum_busvan; } else { echo ""; } ?>" name="price_minimum_busvan" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_busvan)) { echo $price_disposal_busvan; } else { echo ""; } ?>" name="price_disposal_busvan" type="text" />
                                                    </div>
                                                    <hr />
                                                    <input type="submit" class="btn btn-primary" name="businessclass" value="Save Changes">
                                                </form>
                                            </div>
                                    </div>





                                    <!-- ---------------------------tab-3--------------------- -->
                                    <div class="tab-pane fade" id="tab-3">
                                         <p class="mt10"><strong><?php echo _('First Class Sedan'); ?>:</strong> <?php echo _('First class cars like Mercedes Benz S Class, BMW 7 Series, Porsche Panamera or similar'); ?>.</p>
                                        <div class="gap gap-small"></div>
                                        <div class="col-md-4">
                                                <form action="price-settings.php" method="post">
                                                    <h4><?php echo _('First Class Sedan'); ?></h4>

                                                    <?php if(isset($luxclass_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $luxclass_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($luxclass_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $luxclass_erreurid; ?></p>
                                                        </div> <?php } ?>



                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_luxcar)) { echo $price_km_luxcar; } else { echo ""; } ?>" name="price_km_luxcar" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_luxcar)) { echo $price_minimum_luxcar; } else { echo ""; } ?>" name="price_minimum_luxcar" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_luxcar)) { echo $price_disposal_luxcar; } else { echo ""; } ?>" name="price_disposal_luxcar" type="text" />
                                                    </div>

                                                    <div class="gap gap-small"></div>


                                                    <input type="submit" class="btn btn-primary" name="luxuryclass" value="Save Changes">
                                                </form>
                                            </div>
                                    </div>





                                    <!-- ---------------------------tab-4--------------------- -->
                                    <div class="tab-pane fade" id="tab-4">
                                        <div class="gap gap-small"></div>
                                        <div class="col-md-4">
                                                <form action="price-settings.php" method="post">
                                                    <h4><?php echo _('Motorcycle'); ?></h4>

                                                    <?php if(isset($moto_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $moto_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($moto_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $moto_erreurid; ?></p>
                                                        </div> <?php } ?>


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_moto)) { echo $price_km_moto; } else { echo ""; } ?>" name="price_km_moto" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_moto)) { echo $price_minimum_moto; } else { echo ""; } ?>" name="price_minimum_moto" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_moto)) { echo $price_disposal_moto; } else { echo ""; } ?>" name="price_disposal_moto" type="text" />
                                                    </div>

                                                    <div class="gap gap-small"></div>


                                                    <input type="submit" class="btn btn-primary" name="motorcycle" value="Save Changes">
                                                </form>
                                            </div>
                                    </div>





                                    <!-- ---------------------------tab-5--------------------- -->
                                    <div class="tab-pane fade" id="tab-5">
                                        <div class="gap gap-small"></div>
                                        <div class="col-md-4">
                                                <form action="price-settings.php" method="post">
                                                    <h4><?php echo _('Coach'); ?></h4>

                                                    <?php if(isset($coach_ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $coach_ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($coach_erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $coach_erreurid; ?></p>
                                                        </div> <?php } ?>


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Transfers'); ?>: <?php echo _('Price per Kilometer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_km_coach)) { echo $price_km_coach; } else { echo ""; } ?>" name="price_km_coach" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Minimum Price per Transfer'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_minimum_coach)) { echo $price_minimum_coach; } else { echo ""; } ?>" name="price_minimum_coach" type="text" />
                                                    </div>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-euro input-icon"></i>
                                                        <label><?php echo _('Disposals'); ?>: <?php echo _('Price per Hour'); ?></label>
                                                        <input class="form-control" value="<?php if (!empty($price_disposal_coach)) { echo $price_disposal_coach; } else { echo ""; } ?>" name="price_disposal_coach" type="text" />
                                                    </div>

                                                    <div class="gap gap-small"></div>


                                                    <input type="submit" class="btn btn-primary" name="coach" value="Save Changes">
                                                </form>
                                            </div>
                                    </div>
                                </div>
                            </div>







                    </div>

                </div>
            </div>
        </div>



        <div class="gap"></div>


        <?php include '../footer.php'; ?>




        <script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
// [END region_geolocation]

    </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXO2M&signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
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
