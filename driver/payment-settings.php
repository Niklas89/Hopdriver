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


    $sth = $bdd->prepare("SELECT * FROM driver_payment WHERE driverid = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);

    if($sth->rowCount()>0)
    {
        $cash = $result->cash;
        $card = $result->card;
        $water = $result->water;
        $wifi = $result->wifi;
        $magazines = $result->magazines;
    }
    else {


    }



    $sth->closeCursor();

        /*if (! $result) {
        } else { }*/


if(isset($_POST['changesettings']))
{

        if(isset($_POST['cash']))
        {
          $cash = $_POST['cash'];
        }
        else
        {
          $cash = 0;
        }

        if(isset($_POST['card']))
        {
           $card = $_POST['card'];
         }
         else
         {
           $card = 0;
         }

        if(isset($_POST['water'])) { $water = $_POST['water']; } else { $water = 0;}
        if(isset($_POST['wifi'])) { $wifi = $_POST['wifi']; } else { $wifi = 0;}
        if(isset($_POST['magazines'])) { $magazines = $_POST['magazines']; }  else { $magazines = 0;}







     $sthh = $bdd->prepare("SELECT id FROM driver_payment WHERE driverid = :id_users");
        $sthh->execute(array(':id_users' => $id_users));
        $result = $sthh->fetch(PDO::FETCH_OBJ);
    if($sthh->rowCount()==0)
    {


      $reqq = $bdd->prepare('INSERT INTO driver_payment (driverid,cash,card,water,wifi,magazines) VALUES (:id_users,:cash,:card,:water,:wifi,:magazines)');
      $reqq->execute(array(
        'id_users'=>$id_users,
        'cash'=>$cash,
        'card'=>$card,
        'water'=>$water,
        'wifi'=>$wifi,
        'magazines'=>$magazines,

      ));
      $reqq->closeCursor();

        $ok = _("Settings succesfully saved.");
    }


    elseif($sthh->rowCount()>0)
      {

        $req = $bdd->prepare('UPDATE driver_payment SET cash = :cash, card = :card, water = :water, wifi = :wifi, magazines = :magazines
        WHERE driverid = :id_users');
      $req->execute(array(
        'cash'=>$cash,
        'card'=>$card,
        'water'=>$water,
        'wifi'=>$wifi,
        'magazines'=>$magazines,
        'id_users'=>$id_users


      ));
      $req->closeCursor();

        $ok = _("Settings succesfully changed.");
      }


      $sthh->closeCursor();


} // end if isset changesettings






?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('Payment Settings'); ?></title>


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
            <h1 class="page-title"><?php echo _('Payment Settings'); ?></h1>
        </div>




        <div class="container">
            <div class="row">



                <?php $driverfirst_name = $first_name; $driverlast_name = $last_name; ?>
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="row">




                            <!-- ERROR -->
                                                    <?php if(isset($ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $ok; ?></p>
                                                    </div> <?php } ?>



                                                <!-- END ERROR -->
                                                  <form action="payment-settings.php" method="post">

                                                    <h4><?php echo _('Select how you would like to be paid by the passenger'); ?></h4>

                                                    <div class="gap gap-small"></div>


                                                <div class="checkbox">
                                                    <label>

                                                    <input class="i-check" type="checkbox" name="cash" value="1"  <?php  if (isset($cash) && $cash== 1){ echo 'checked="checked"'; }  ?>/> <?php echo _('Cash'); ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                    <input class="i-check" type="checkbox" name="card" value="1"  <?php  if (isset($card) && $card== 1){ echo 'checked="checked"'; }  ?>/> <?php echo _('Credit Card'); ?></label>
                                                </div>

                                                    <div class="gap gap-small"></div>

                                                    <h4><?php echo _('Additional Elements Onboard'); ?></h4>

                                                    <div class="gap gap-small"></div>

                                                <div class="checkbox">
                                                    <label>
                                                        <input class="i-check" type="checkbox" name="water" value="1"  <?php  if (isset($water) && $water== 1){ echo 'checked="checked"'; }  ?>/><?php echo _('Bottles of water'); ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input class="i-check" type="checkbox" name="wifi" value="1"  <?php  if (isset($wifi) && $wifi== 1){ echo 'checked="checked"'; }  ?> /><?php echo _('Wifi'); ?></label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input class="i-check" type="checkbox" name="magazines" value="1"  <?php  if (isset($magazines) && $magazines== 1){ echo 'checked="checked"'; }  ?> /><?php echo _('Magazines'); ?></label>
                                                </div>

                                                    <div class="gap gap-small"></div>

                                                    <div class="gap gap-small"></div>

                                                <input type="submit" class="btn btn-primary" name="changesettings" value="Save Changes">

                                                </form>











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
