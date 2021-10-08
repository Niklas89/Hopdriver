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
    <title>HopDriver - <?php echo _('User Profile'); ?></title>


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
            <h1 class="page-title"><?php echo _('Driver Profile'); ?></h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <h4><?php echo _('Total Offers'); ?></h4>
                    <ul class="list list-inline user-profile-statictics mb30">
                        <li><a href="transfers.php" title="<?php echo _('New Transfers'); ?>"><i class="fa fa-cab user-profile-statictics-icon"></i>
                            <?php 
                                 $sth = $bdd->query("SELECT COUNT(id) AS numid FROM transfers_booking WHERE accepted=0 AND origin LIKE '%".$drivercountry."%'");
                                $result = $sth->fetch(PDO::FETCH_OBJ);
                                $numtransfers = $result->numid;
                                $sth->closeCursor(); ?>
                            <h5>
                                <?php echo $numtransfers; ?>  
                            </h5>
                            <p><?php echo _('New Transfers'); ?></p></a>
                        </li>
                        <li><a href="disposals.php" title="<?php echo _('New Disposals'); ?>"><i class="fa fa-car user-profile-statictics-icon"></i>
                            <?php 
                                 $sth = $bdd->query("SELECT COUNT(id) AS numid FROM disposal_booking WHERE accepted=0 AND pick_up_loc LIKE '%".$drivercountry."%'");
                                $result = $sth->fetch(PDO::FETCH_OBJ);
                                $numtransfers = $result->numid;
                                $sth->closeCursor(); ?>
                            <h5>
                                <?php echo $numtransfers; ?>  
                            </h5>
                            <p><?php echo _('New Disposals'); ?></p></a>
                        </li>
                        <!--<li><i class="fa fa-building-o user-profile-statictics-icon"></i>
                            <h5>15</h5>
                            <p>Cityes</p>
                        </li>
                        <li><i class="fa fa-flag-o user-profile-statictics-icon"></i>
                            <h5>3</h5>
                            <p>Countries</p>
                        </li>
                        <li><i class="fa fa-plane user-profile-statictics-icon"></i>
                            <h5>20</h5>
                            <p>Trips</p>
                        </li> -->
                    </ul>
                </div>

                <div class="col-md-9">
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />-->3 <?php echo _('latest transfers'); ?>:</label>
                    </div>
                    <table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr><!-- utiliser la table transfers_booking et disposal_booking    -->
                                <th><?php echo _('Vehicle'); ?></th> <!-- transfer or disposal -->
                                <th><?php echo _('Origin'); ?></th>
                                <th><?php echo _('Destination'); ?></th>
                                <th><?php echo _('Pick-Up Date'); ?></th>
                                <th><?php echo _('Pick-Up Time'); ?></th>
                                <th><?php echo _('Details'); ?></th><!-- eco car or van, bus car or van, lux -->
                                <th><?php echo _('Confirmed'); ?></th>
                                <th><?php echo _('Accept/Cancel'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 


                     

      



                              $resultats=$bdd->query('SELECT * FROM transfers_booking WHERE accepted=0 AND origin LIKE "%'.$drivercountry.'%" ORDER BY coldate DESC LIMIT 3');
                              $resultats->setFetchMode(PDO::FETCH_OBJ);
                              while( $resultat = $resultats->fetch() )
                              { 


                                ?>

                                         
                                        <tr>
                                            <td class="booking-history-title"><?php echo $resultat->service; ?>
                                            </td>
                                            <td><?php echo $resultat->origin; ?></td>
                                            <td><?php echo $resultat->destination; ?></td>
                                            <td><?php echo $resultat->pickupdate; ?></td>
                                            <td><?php echo $resultat->pickuptime; ?></td>
                                            <td><a class="btn btn-info btn-sm" href="transferdetails.php?id=<?php echo $resultat->id; ?>" title="<?php echo _('More details'); ?>"><?php echo _('Infos'); ?></a></td>
                                            <?php if ($resultat->accepted == 1 ) { ?> 
                                            <td class="text-center"><i class="fa fa-check"></i>
                                            </td>
                                            <td class="text-center"><a class="btn btn-warning btn-sm" href="transfers.php?cancel=<?php echo urlencode($resultat->id); ?>" title="<?php echo _('Cancel'); ?>"><?php echo _('Cancel'); ?></a>
                                            </td>
                                            <?php } else { ?>
                                            <td class="text-center"><i class="fa fa-circle-o"></i>
                                            </td>
                                            <td class="text-center"><a class="btn btn-success btn-sm" href="transfers.php?valid=<?php echo urlencode($resultat->id); ?>" title="<?php echo _('Accept'); ?>"><?php echo _('Accept'); ?></a>
                                            </td>
                                            <?php } ?>
                                        </tr>


                                          

                                      <?php 
                              }
                              $resultats->closeCursor();

                              ?> 
                        </tbody>
                    </table>
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />-->3 <?php echo _('latest disposals'); ?>:</label>
                    </div>
                    <table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr><!-- utiliser la table transfers_booking et disposal_booking    -->
                                <th><?php echo _('Vehicle'); ?></th> <!-- transfer or disposal -->
                                <th><?php echo _('Pick-Up Location'); ?></th>
                                <th><?php echo _('Pick-Up Date'); ?></th>
                                <th><?php echo _('Pick-Up Time'); ?></th>
                                <th><?php echo _('Last Day'); ?></th>
                                <th><?php echo _('Hours / Day'); ?></th>
                                <th><?php echo _('Details'); ?></th><!-- eco car or van, bus car or van, lux -->
                                <th><?php echo _('Confirmed'); ?></th>
                                <th><?php echo _('Accept/Cancel'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 


                     

      



                              $resultats=$bdd->query('SELECT * FROM disposal_booking WHERE accepted=0 AND pick_up_loc LIKE "%'.$drivercountry.'%" ORDER BY coldate DESC LIMIT 3');
                              $resultats->setFetchMode(PDO::FETCH_OBJ);
                              while( $resultat = $resultats->fetch() )
                              { 


                                ?>

                                         
                                        <tr>
                                            <td class="booking-history-title"><?php echo $resultat->service; ?>
                                            </td>
                                            <td><?php echo $resultat->pick_up_loc; ?></td>
                                            <td><?php echo $resultat->pickupdate; ?></td>
                                            <td><?php echo $resultat->pickuptime; ?></td>
                                            <td><?php echo $resultat->drop_off_date; ?></td>
                                            <td><?php echo $resultat->hoursday; ?></td>
                                            <td><a class="btn btn-info btn-sm" href="disposaldetails.php?id=<?php echo $resultat->id; ?>" title="<?php echo _('More details'); ?>"><?php echo _('Infos'); ?></a></td>
                                            <?php if ($resultat->accepted == 1 ) { ?> 
                                            <td class="text-center"><i class="fa fa-check"></i>
                                            </td>
                                            <td class="text-center"><a class="btn btn-warning btn-sm" href="disposals.php?cancel=<?php echo urlencode($resultat->id); ?>" title="<?php echo _('Cancel'); ?>"><?php echo _('Cancel'); ?></a>
                                            </td>
                                            <?php } else { ?>
                                            <td class="text-center"><i class="fa fa-circle-o"></i>
                                            </td>
                                            <td class="text-center"><a class="btn btn-success btn-sm" href="disposals.php?valid=<?php echo urlencode($resultat->id); ?>" title="<?php echo _('Accept'); ?>"><?php echo _('Accept'); ?></a>
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


