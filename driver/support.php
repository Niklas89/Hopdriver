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


    $sth = $bdd->prepare("SELECT first_name, last_name, email FROM chauffeurs WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('Support'); ?></title>


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
            <h1 class="page-title"><?php echo _('Support'); ?></h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <h4><?php echo _('Any questions ?'); ?></h4>
                    <p><?php echo _('Email us at'); ?> <a href="mailto:drivers@email.com" target="_top">drivers@email.com</a></p>
                    <p><?php echo _('Call us at'); ?> <a href="#">+33 9 77 55 52 55</a></p>
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


