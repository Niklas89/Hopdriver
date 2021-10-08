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
if(empty($_SESSION['lang'])){ $lang = 'en_US'; }

require "localization.php"; 

$id = $_GET['id'];

  include '../config.php';

  $sth = $bdd->prepare("SELECT first_name, last_name, email FROM clients WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;


  $sth = $bdd->prepare("SELECT driverid, clientid FROM disposal_booking WHERE id = ".$id);
        $sth->execute(array(':id' => $id));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driverid = $result->driverid;
        $clientid = $result->clientid;

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
            <h1 class="page-title"><?php echo _('Disposal Details'); ?></h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />Disposal details are indicated below:</label>-->
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
                                        <tr><td class="booking-history-title"><?php echo _('Your Name'); ?></td><td><?php echo $resultat->first_name; ?> <?php echo $resultat->last_name; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Flight Number'); ?></td><td><?php echo $resultat->flightnumber; ?></td></tr> 
                                        <tr><td class="booking-history-title"><?php echo _('Phone'); ?></td><td><?php echo $resultat->phone; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _('Description'); ?></td><td><?php echo nl2br($resultat->comments); ?></td></tr>
                                       <tr><td class="booking-history-title">Price</td><td><?php echo $resultat->price; ?>€</td></tr>
                                       <tr><td class="text-center"><?php echo _('Confirmed'); ?></td>
                                       <?php if ($resultat->driverid == $id_users ) { ?> 
                                            <td class="text-center"><i class="fa fa-check"></i></td>
                                            <?php } else { ?> <td class="text-center"><i class="fa fa-circle-o"></i>
                                            </td></tr>
                                            <?php 

                                                }
                                   
                              }
                              $resultats->closeCursor();

                              ?> 


                        </tbody>
                    </table>

                    <table class="table table-bordered table-striped table-booking-history">
                        <h2><?php echo _('Driver Details'); ?></h2>
                        <tbody>




                            <?php  $resultats=$bdd->query('SELECT * FROM chauffeurs WHERE id=' . $driverid);
                      $resultats->setFetchMode(PDO::FETCH_OBJ);
                      while( $resultat = $resultats->fetch() )
                      {

                                ?>
                                         
                                        <tr><td class="booking-history-title"><?php echo _("Driver's Name"); ?></td><td><?php echo $resultat->first_name; ?> <?php echo $resultat->last_name; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _("Driver's E-mail"); ?></td><td><?php echo $resultat->email; ?></td></tr> 
                                        <tr><td class="booking-history-title"><?php echo _("Driver's Phone Number"); ?></td><td><?php echo $resultat->phone; ?></td></tr>
                                        <tr><td class="booking-history-title"><?php echo _("Driver's Company"); ?></td><td><?php echo $resultat->company; ?></td></tr>
                                            
                                          

                                    
                                   
                             <?php }
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


