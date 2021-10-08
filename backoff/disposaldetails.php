<?php
session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
  header('Location: login.php');
  exit();
}

  include '../config.php';

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Voklee - Disposal Details</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="airport transfers, private transfer, Voklee, disposal services" />
    <meta name="description" content="Voklee - private transfers and disposal services">
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
            <h1 class="page-title">New Disposals</h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />-->Disposal details are indicated below:</label>
                    </div>
                    <table class="table table-bordered table-striped table-booking-history">
                        <tbody>
                             <?php 


                     

      



                               $resultats=$bdd->query('SELECT * FROM disposal_booking WHERE id=\'' . $_GET['id'] . '\' ORDER BY coldate DESC');
                      $resultats->setFetchMode(PDO::FETCH_OBJ);
                      while( $resultat = $resultats->fetch() )
                      {

                                ?>
                                         
                                        <tr><td class="booking-history-title">Vehicle</td><td><?php echo $resultat->service; ?></td></tr> 
                                        <tr><td class="booking-history-title">Pick-Up Location</td><td><?php echo $resultat->pick_up_loc; ?></td></tr>
                                        <tr><td class="booking-history-title">Pick-Up Date</td><td><?php echo $resultat->pickupdate; ?></td></tr>
                                        <tr><td class="booking-history-title">Pick-Up Time</td><td><?php echo $resultat->pickuptime; ?></td></tr> 
                                        <tr><td class="booking-history-title">Last Day</td><td><?php echo $resultat->drop_off_date; ?></td></tr>
                                        <tr><td class="booking-history-title">Last Day Drop-Off Time</td><td><?php echo $resultat->drop_off_time; ?></td></tr>
                                        <tr><td class="booking-history-title">Last Day Drop-Off Location</td><td><?php echo $resultat->drop_off_loc; ?></td></tr>
                                        <tr><td class="booking-history-title">Hours / Day</td><td><?php echo $resultat->hoursday; ?></td></tr>
                                        <tr><td class="booking-history-title">Client Name</td><td><?php echo $resultat->first_name; ?> <?php echo $resultat->last_name; ?></td></tr>
                                        <tr><td class="booking-history-title">Flight Number</td><td><?php echo $resultat->flightnumber; ?></td></tr> 
                                        <tr><td class="booking-history-title">Phone</td><td><?php echo $resultat->phone; ?></td></tr>
                                        <tr><td class="booking-history-title">Comments</td><td><?php echo nl2br($resultat->comments); ?></td></tr>
                                        <tr><td class="booking-history-title">Your Price</td><td><?php echo $resultat->price; ?> €</td></tr>
                                        <!--<tr><td class="text-center">Edit details (when we set price = we confirm)</td>
                                            <td class="text-center"><a class="btn btn-info btn-sm" href="editdisposal.php?id=<?php echo urlencode($resultat->id); ?>">Edit</a></td></tr>-->


                                          

                                      <?php 
                                   
                              }
                              $resultats->closeCursor();

                              $bookingid = $_GET['id'] ;

                              $sth = $bdd->prepare("SELECT driverid FROM disposal_booking WHERE id = :bookingid");
                                $sth->execute(array(':bookingid' => $bookingid));
                                $result = $sth->fetch(PDO::FETCH_OBJ);
                                $sth->closeCursor();
                                $driverid = $result->driverid;

                              $stt = $bdd->prepare("SELECT * FROM chauffeurs WHERE id = :driverid");
                                $stt->execute(array(':driverid' => $driverid));
                                $resultresa = $stt->fetch(PDO::FETCH_OBJ);
                                $stt->closeCursor();
                                $driverfirst_name = $resultresa->first_name;
                                $driverlast_name = $resultresa->last_name;
                                $driverphone = $resultresa->phone;
                                $driveremail = $resultresa->email;
                                $drivercompany = $resultresa->company;


                                ?> 


                              <tr><td class="booking-history-title">Driver Name</td><td><?php echo $driverfirst_name; ?> <?php echo $driverlast_name; ?></td></tr>
                              <tr><td class="booking-history-title">Driver Company</td><td><?php echo $drivercompany; ?> </td></tr>
                              <tr><td class="booking-history-title">Driver Email</td><td><?php echo $driveremail; ?> </td></tr>
                              <tr><td class="booking-history-title">Driver Phone</td><td><?php echo $driverphone; ?> </td></tr>

                              
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


