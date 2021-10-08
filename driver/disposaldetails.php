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

  $sth = $bdd->prepare("SELECT first_name, last_name, email, country FROM chauffeurs WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;
        $drivercountry = $result->country;


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('Disposal Details'); ?></title>


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
            <h1 class="page-title"><?php echo _('New Disposal'); ?></h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />--><?php echo _('Disposal details are indicated below'); ?>:</label>
                    </div>
                    <table class="table table-bordered table-striped table-booking-history">
                        <tbody>
                             <?php 


                     

      



                               $resultats=$bdd->query('SELECT * FROM disposal_booking WHERE id=\'' . $_GET['id'] . '\' ORDER BY coldate DESC');
                      $resultats->setFetchMode(PDO::FETCH_OBJ);
                      while( $resultat = $resultats->fetch() )
                      {

                                ?>
                                         
                                        <tr><td class="booking-history-title"><?php echo _('Vehicle'); ?></td><td><?php echo $resultat->service; ?></td></tr> 
                                        <tr><td class="booking-history-title"><?php echo _('Pick-Up Location'); ?></td><td><?php echo $resultat->pick_up_loc; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Pick-Up Date'); ?></td><td><?php echo $resultat->pickupdate; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Pick-Up Time'); ?></td><td><?php echo $resultat->pickuptime; ?></td></tr> 
                                        <tr><td class="booking-history-title"><?php echo _('Last Day'); ?></td><td><?php echo $resultat->drop_off_date; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Last Day Drop-Off Time'); ?></td><td><?php echo $resultat->drop_off_time; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Last Day Drop-Off Location'); ?></td><td><?php echo $resultat->drop_off_loc; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Hours / Day'); ?></td><td><?php echo $resultat->hoursday; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Client Name'); ?></td><td><?php echo $resultat->first_name; ?> <?php echo $resultat->last_name; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Flight Number'); ?></td><td><?php echo $resultat->flightnumber; ?></td></tr> 
                                        <tr><td class="booking-history-title"><?php echo _('Phone'); ?></td><td><?php echo $resultat->phone; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Comments'); ?></td><td><?php echo nl2br($resultat->comments); ?></td></tr>
                                            <?php if ($resultat->driverid == $id_users ) { ?> 
                                        <tr><td class="text-center"><a class="btn btn-warning btn-sm" href="disposals.php?cancel=<?php echo urlencode($resultat->id); ?>" title="<?php echo _('Cancel'); ?>"><?php echo _('Cancel'); ?></a></td>
                                            <td class="text-center"><i class="fa fa-check"></i></td></tr>
                                            <?php } else { ?>
                                        <tr><td class="text-center"><a class="btn btn-success btn-sm" href="disposals.php?valid=<?php echo urlencode($resultat->id); ?>" title="<?php echo _('Accept'); ?>"><?php echo _('Accept'); ?></a>
                                            </td><td class="text-center"><i class="fa fa-circle-o"></i>
                                            </td>
                                            <?php } ?>
                                          </tr>


                                          

                                      <?php 
                                   
                              }
                              $resultats->closeCursor();

                              ?> 
                        </tbody>
                    </table>
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


