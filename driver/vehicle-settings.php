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
        $first_name = $result->first_name;
        $last_name = $result->last_name;


    $sth = $bdd->prepare("SELECT * FROM driver_vehicles WHERE driverid = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();

        if (! $result) {

        } else {

        $ecocar = $result->ecocar;
        $ecocar = $result->ecocar;
        $ecovan = $result->ecovan;
        $buscar = $result->buscar;
        $busvan = $result->busvan;
        $luxcar = $result->luxcar;
        $moto = $result->moto;
        $coach = $result->coach; }


    $sth = $bdd->prepare("SELECT * FROM driver_seats WHERE driverid = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $resultt = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();

        if ($resultt)
        {
        $ecocar_seats = $resultt->ecocar;
        $ecovan_seats = $resultt->ecovan;
        $buscar_seats = $resultt->buscar;
        $busvan_seats = $resultt->busvan;
        $luxcar_seats = $resultt->luxcar;
        $moto_seats = $resultt->moto;
        $coach_seats = $resultt->coach;
      }



    $sth = $bdd->prepare("SELECT * FROM driver_luggage WHERE driverid = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $resulttt = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();

        if (! $resulttt) {
        } else {
        $ecocar_suitcases = $resulttt->ecocar;
        $ecovan_suitcases = $resulttt->ecovan;
        $buscar_suitcases = $resulttt->buscar;
        $busvan_suitcases = $resulttt->busvan;
        $luxcar_suitcases = $resulttt->luxcar;
        $moto_suitcases = $resulttt->moto;
        $coach_suitcases = $resulttt->coach; }




if(isset($_POST['economyclass']))  {
  if(
    !empty($_POST['ecocar']) || !empty($_POST['ecovan'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $ecoclass_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $ecocar = $_POST['ecocar'];
        $ecovan = $_POST['ecovan'];
        $ecocar_seats = $_POST['ecocar_seats'];
        $ecovan_seats = $_POST['ecovan_seats'];
        $ecocar_suitcases = $_POST['ecocar_suitcases'];
        $ecovan_suitcases = $_POST['ecovan_suitcases'];



      $req = $bdd->prepare('SELECT id FROM driver_vehicles  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_vehicles (driverid,ecocar,ecovan) VALUES (:id_users,:ecocar,:ecovan)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'ecocar'=>$ecocar,
        'ecovan'=>$ecovan,

      ));
      $reqq->closeCursor();


      $reqqq = $bdd->prepare('INSERT INTO driver_seats (driverid,ecocar,ecovan) VALUES (:id_users,:ecocar_seats,:ecovan_seats)');
      $reqqq->execute(array(
        'id_users'=>$id_users,
        'ecocar_seats'=>$ecocar_seats,
        'ecovan_seats'=>$ecovan_seats,

      ));
      $reqqq->closeCursor();


      $reqqqq = $bdd->prepare('INSERT INTO driver_luggage (driverid,ecocar,ecovan) VALUES (:id_users,:ecocar_suitcases,:ecovan_suitcases)');
      $reqqqq->execute(array(
        'id_users'=>$id_users,
        'ecocar_suitcases'=>$ecocar_suitcases,
        'ecovan_suitcases'=>$ecovan_suitcases,

      ));
      $reqqqq->closeCursor();

        $ecoclass_ok = _("Settings succesfully saved.");
    }


    elseif($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_vehicles SET ecocar = :ecocar, ecovan = :ecovan
        WHERE driverid = :id_users');
      $req->execute(array(
        'ecocar'=>$ecocar,
        'ecovan'=>$ecovan,
        'id_users'=>$id_users


      ));


         $reqq = $bdd->prepare('UPDATE driver_seats SET ecocar = :ecocar_seats, ecovan = :ecovan_seats
        WHERE driverid = :id_users');
      $reqq->execute(array(
        'ecocar_seats'=>$ecocar_seats,
        'ecovan_seats'=>$ecovan_seats,
        'id_users'=>$id_users

      ));

      $reqqq = $bdd->prepare('UPDATE driver_luggage SET ecocar = :ecocar_suitcases, ecovan = :ecovan_suitcases
        WHERE driverid = :id_users');
      $reqqq->execute(array(
        'ecocar_suitcases'=>$ecocar_suitcases,
        'ecovan_suitcases'=>$ecovan_suitcases,
        'id_users'=>$id_users

      ));

        $ecoclass_ok = _("Settings succesfully changed.");
      }


      $req->closeCursor();








       } //end if valid
} // end if isset economyclass






if(isset($_POST['businessclass']))  {
  if(
    !empty($_POST['buscar']) || !empty($_POST['busvan'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $busclass_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $buscar = $_POST['buscar'];
        $busvan = $_POST['busvan'];
        $buscar_seats = $_POST['buscar_seats'];
        $busvan_seats = $_POST['busvan_seats'];
        $buscar_suitcases = $_POST['buscar_suitcases'];
        $busvan_suitcases = $_POST['busvan_suitcases'];







     $req = $bdd->prepare('SELECT id FROM driver_vehicles  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_vehicles (driverid,buscar,busvan) VALUES (:id_users,:buscar,:busvan)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'buscar'=>$buscar,
        'busvan'=>$busvan,

      ));
      $reqq->closeCursor();


      $reqqq = $bdd->prepare('INSERT INTO driver_seats (driverid,buscar,busvan) VALUES (:id_users,:buscar_seats,:busvan_seats)');
      $reqqq->execute(array(
        'id_users'=>$id_users,
        'buscar_seats'=>$buscar_seats,
        'busvan_seats'=>$busvan_seats,

      ));
      $reqqq->closeCursor();


      $reqqqq = $bdd->prepare('INSERT INTO driver_luggage (driverid,buscar,busvan) VALUES (:id_users,:buscar_suitcases,:busvan_suitcases)');
      $reqqqq->execute(array(
        'id_users'=>$id_users,
        'buscar_suitcases'=>$buscar_suitcases,
        'busvan_suitcases'=>$busvan_suitcases,

      ));
      $reqqqq->closeCursor();

        $busclass_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_vehicles SET buscar = :buscar, busvan = :busvan
        WHERE driverid = :id_users');
      $req->execute(array(
        'buscar'=>$buscar,
        'busvan'=>$busvan,
        'id_users'=>$id_users

      ));


         $reqq = $bdd->prepare('UPDATE driver_seats SET buscar = :buscar_seats, busvan = :busvan_seats
        WHERE driverid = :id_users');
      $reqq->execute(array(
        'buscar_seats'=>$buscar_seats,
        'busvan_seats'=>$busvan_seats,
        'id_users'=>$id_users

      ));

      $reqqq = $bdd->prepare('UPDATE driver_luggage SET buscar = :buscar_suitcases, busvan = :busvan_suitcases
        WHERE driverid = :id_users');
      $reqqq->execute(array(
        'buscar_suitcases'=>$buscar_suitcases,
        'busvan_suitcases'=>$busvan_suitcases,
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
    !empty($_POST['luxcar'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $luxclass_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $luxcar = $_POST['luxcar'];
        $luxcar_seats = $_POST['luxcar_seats'];
        $luxcar_suitcases = $_POST['luxcar_suitcases'];






     $req = $bdd->prepare('SELECT id FROM driver_vehicles  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_vehicles (driverid,luxcar) VALUES (:id_users,:luxcar)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'luxcar'=>$luxcar,

      ));
      $reqq->closeCursor();


      $reqqq = $bdd->prepare('INSERT INTO driver_seats (driverid,luxcar) VALUES (:id_users,:luxcar_seats)');
      $reqqq->execute(array(
        'id_users'=>$id_users,
        'luxcar_seats'=>$luxcar_seats,

      ));
      $reqqq->closeCursor();


      $reqqqq = $bdd->prepare('INSERT INTO driver_luggage (driverid,luxcar) VALUES (:id_users,:luxcar_suitcases)');
      $reqqqq->execute(array(
        'id_users'=>$id_users,
        'luxcar_suitcases'=>$luxcar_suitcases,

      ));
      $reqqqq->closeCursor();

        $luxclass_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_vehicles SET luxcar = :luxcar
        WHERE driverid = :id_users');
      $req->execute(array(
        'luxcar'=>$luxcar,
        'id_users'=>$id_users

      ));


         $reqq = $bdd->prepare('UPDATE driver_seats SET luxcar = :luxcar_seats
        WHERE driverid = :id_users');
      $reqq->execute(array(
        'luxcar_seats'=>$luxcar_seats,
        'id_users'=>$id_users

      ));

      $reqqq = $bdd->prepare('UPDATE driver_luggage SET luxcar = :luxcar_suitcases
        WHERE driverid = :id_users');
      $reqqq->execute(array(
        'luxcar_suitcases'=>$luxcar_suitcases,
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
    !empty($_POST['moto'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $moto_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $moto = $_POST['moto'];
        $moto_seats = $_POST['moto_seats'];
        $moto_suitcases = $_POST['moto_suitcases'];






     $req = $bdd->prepare('SELECT id FROM driver_vehicles  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_vehicles (driverid,moto) VALUES (:id_users,:moto)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'moto'=>$moto,

      ));
      $reqq->closeCursor();


      $reqqq = $bdd->prepare('INSERT INTO driver_seats (driverid,moto) VALUES (:id_users,:moto_seats)');
      $reqqq->execute(array(
        'id_users'=>$id_users,
        'moto_seats'=>$moto_seats,

      ));
      $reqqq->closeCursor();


      $reqqqq = $bdd->prepare('INSERT INTO driver_luggage (driverid,moto) VALUES (:id_users,:moto_suitcases)');
      $reqqqq->execute(array(
        'id_users'=>$id_users,
        'moto_suitcases'=>$moto_suitcases,

      ));
      $reqqqq->closeCursor();

        $moto_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_vehicles SET moto = :moto
        WHERE driverid = :id_users');
      $req->execute(array(
        'moto'=>$moto

      ));


         $reqq = $bdd->prepare('UPDATE driver_seats SET moto = :moto_seats
        WHERE driverid = :id_users');
      $reqq->execute(array(
        'moto_seats'=>$moto_seats,
        'id_users'=>$id_users

      ));

      $reqqq = $bdd->prepare('UPDATE driver_luggage SET moto = :moto_suitcases
        WHERE driverid = :id_users');
      $reqqq->execute(array(
        'moto_suitcases'=>$moto_suitcases,
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
    !empty($_POST['coach'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $coach_erreurid = _('Please fill in all the fields.');
    }


    if($valid)
    {


        $coach = $_POST['coach'];
        $coach_seats = $_POST['coach_seats'];
        $coach_suitcases = $_POST['coach_suitcases'];







     $req = $bdd->prepare('SELECT id FROM driver_vehicles  WHERE driverid = :id_users');
      $req->execute(array(
        'id_users'=>$id_users));
        $result = $req->fetch(PDO::FETCH_OBJ);
    if($req->rowCount()==0)
    {
      $reqq = $bdd->prepare('INSERT INTO driver_vehicles (driverid,coach) VALUES (:id_users,:coach)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'coach'=>$coach,

      ));
      $reqq->closeCursor();


      $reqqq = $bdd->prepare('INSERT INTO driver_seats (driverid,coach) VALUES (:id_users,:coach_seats)');
      $reqqq->execute(array(
        'id_users'=>$id_users,
        'coach_seats'=>$coach_seats,

      ));
      $reqqq->closeCursor();


      $reqqqq = $bdd->prepare('INSERT INTO driver_luggage (driverid,coach) VALUES (:id_users,:coach_suitcases)');
      $reqqqq->execute(array(
        'id_users'=>$id_users,
        'coach_suitcases'=>$coach_suitcases,

      ));
      $reqqqq->closeCursor();

        $coach_ok = _("Settings succesfully saved.");
    }


    else
    {
      if($req->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_vehicles SET coach = :coach
        WHERE driverid = :id_users');
      $req->execute(array(
        'coach'=>$coach,

      ));


         $reqq = $bdd->prepare('UPDATE driver_seats SET coach = :coach_seats
        WHERE driverid = :id_users');
      $reqq->execute(array(
        'coach_seats'=>$coach_seats,
        'id_users'=>$id_users

      ));

      $reqqq = $bdd->prepare('UPDATE driver_luggage SET coach = :coach_suitcases
        WHERE driverid = :id_users');
      $reqqq->execute(array(
        'coach_suitcases'=>$coach_suitcases,
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
    <title>HopDriver - <?php echo _('Vehicle Settings'); ?></title>


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
            <h1 class="page-title"><?php echo _('Vehicle Settings'); ?></h1>
        </div>




        <div class="container">
            <div class="row">



                <?php $driverfirst_name = $first_name; $driverlast_name = $last_name; ?>
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="row">


                            <h4><?php echo _('Enter the brand and model of your vehicles for each service'); ?></h4>


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
                                        <div class="col-md-4">
                                                <form action="vehicle-settings.php" method="post">
                                                    <h4><?php echo _('Economy Sedan'); ?></h4>

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


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="ecocar" id="ecocar" class="form-control" type="textarea" /><?php if (!empty($ecocar)) { echo $ecocar; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="ecocar_seats"class="form-control" >
                                                                    <?php if (!empty($ecocar_seats)) { echo '<option>'.$ecocar_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option >1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="ecocar_suitcases" class="form-control" >
                                                                    <?php if (!empty($ecocar_suitcases)) { echo '<option>'.$ecocar_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option >1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                  </div>

                                                    <div class="gap gap-small"></div>


                                                    <hr>
                                            </div>
                                            <div class="col-md-4 col-md-offset-1">
                                                <h4><?php echo _('Economy Van'); ?></h4>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="ecovan" id="ecovan" class="form-control" type="textarea" /><?php if (!empty($ecovan)) { echo $ecovan; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="ecovan_seats"class="form-control" >
                                                                    <?php if (!empty($ecovan_seats)) { echo '<option>'.$ecovan_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="ecovan_suitcases" class="form-control" >
                                                                    <?php if (!empty($ecovan_suitcases)) { echo '<option>'.$ecovan_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                  </div>

                                                    <div class="gap gap-small"></div>
                                                    <hr />
                                                    <input type="submit" class="btn btn-primary" name="economyclass" value="Save Changes">
                                                </form>
                                            </div>
                                    </div>



                                    <!-- ---------------------------tab-2--------------------- -->
                                    <div class="tab-pane fade" id="tab-2">
                                         <p class="mt10"><strong><?php echo _('Business Sedan'); ?>:</strong> <?php echo _('business class cars like Mercedes-Benz E Class, BMW 5 Series, Audi A6 or similar'); ?>.<br /> <strong><?php echo _('Business Van'); ?>:</strong> <?php echo _('business class vans like Mercedes-Benz Viano, Mercedes-Benz Class V, Volkswagen Multivan or similar'); ?>.</p>
                                        <div class="gap gap-small"></div>
                                        <div class="col-md-4">
                                                <form action="vehicle-settings.php" method="post">
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


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="buscar" id="buscar" class="form-control" type="textarea" /><?php if (!empty($buscar)) { echo $buscar; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="buscar_seats"class="form-control" >
                                                                    <?php if (!empty($buscar_seats)) { echo '<option>'.$buscar_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="buscar_suitcases" class="form-control" >
                                                                    <?php if (!empty($buscar_suitcases)) { echo '<option>'.$buscar_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                  </div>

                                                    <div class="gap gap-small"></div>


                                                    <hr>
                                            </div>
                                            <div class="col-md-4 col-md-offset-1">
                                                <h4><?php echo _('Business Van'); ?></h4>
                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="busvan" id="busvan" class="form-control" type="textarea" /><?php if (!empty($busvan)) { echo $busvan; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="busvan_seats"class="form-control" >
                                                                    <?php if (!empty($busvan_seats)) { echo '<option>'.$busvan_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="busvan_suitcases" class="form-control" >
                                                                    <?php if (!empty($busvan_suitcases)) { echo '<option>'.$busvan_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
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
                                                <form action="vehicle-settings.php" method="post">
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



                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="luxcar" id="luxcar" class="form-control" type="textarea" /><?php if (!empty($luxcar)) { echo $luxcar; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="luxcar_seats"class="form-control" >
                                                                    <?php if (!empty($luxcar_seats)) { echo '<option>'.$luxcar_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="luxcar_suitcases" class="form-control" >
                                                                    <?php if (!empty($luxcar_suitcases)) { echo '<option>'.$luxcar_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
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
                                                <form action="vehicle-settings.php" method="post">
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


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="moto" id="moto" class="form-control" type="textarea" /><?php if (!empty($moto)) { echo $moto; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="moto_seats"class="form-control" >
                                                                    <?php if (!empty($moto_seats)) { echo '<option>'.$moto_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="moto_suitcases" class="form-control" >
                                                                    <?php if (!empty($moto_suitcases)) { echo '<option>'.$moto_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
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
                                                <form action="vehicle-settings.php" method="post">
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


                                                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon"></i>
                                                        <label><?php echo _('Vehicles (Brand and Model)'); ?></label>
                                                        <textarea rows="7" cols="70" name="coach" id="coach" class="form-control" type="textarea" /><?php if (!empty($coach)) { echo $coach; } else { echo ""; } ?></textarea>
                                                    </div>


                                                    <div class="col-md-5">
                                                                  <label><strong><?php echo _('Passengers accepted'); ?></strong></label>
                                                                    <div class="gap gap-small"></div>
                                                                  <label><strong><?php echo _('Suitcases accepted'); ?></strong></label>
                                                                  </div>

                                                                  <div class="col-md-5">
                                                                  <select name="coach_seats"class="form-control" >
                                                                    <?php if (!empty($coach_seats)) { echo '<option>'.$coach_seats.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
                                                                   <div class="gap gap-small"></div>
                                                                   <div class="gap gap-small"></div>

                                                                    <select name="coach_suitcases" class="form-control" >
                                                                    <?php if (!empty($coach_suitcases)) { echo '<option>'.$coach_suitcases.'</option>'; } else { echo "<option>1</option>"; } ?>
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                    </select>
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
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
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
