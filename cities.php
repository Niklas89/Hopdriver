<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; } 
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

require "localization.php"; 
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - Cities</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Paris airport transfers, HopDriver, disposal services" />
    <meta name="description" content="HopDriver - Paris aiport transfers and disposal services">
    <meta name="author" content="Niklas Edelstam">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mystyles.css">
    <script src="js/modernizr.js"></script>


</head>

<body>
    <div class="global-wrap">
        
        <?php include 'header_cities.php'; ?>

        <div class="container">
            <h1 class="page-title"><?php echo _("Drivers in 6 Countries"); ?></h1>
        </div>




        <div class="container">
            <div id="popup-gallery">
                <div class="row row-col-gap">
                    <div class="col-md-4">
                        <h5>Paris</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/paris800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/paris800x600.jpg" alt="Paris" title="Paris" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5>Berlin</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/berlin800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/berlin800x600.jpg" alt="Berlin" title="Berlin" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5>London</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/london800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/london800x600.jpg" alt="London" title="London" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5>Dublin</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/dublin800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/dublin800x600.jpg" alt="Dublin" title="Dublin" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5>Madrid</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/madrid800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/madrid800x600.jpg" alt="Madrid" title="Madrid" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5>Barcelona</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/barcelona800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/barcelona800x600.jpg" alt="Barcelona" title="Barcelona" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5>Rome</h5>
                        <a class="hover-img popup-gallery-image" href="img/cars/cities/rome800x600.jpg" data-effect="mfp-zoom-out">
                            <img src="img/cars/cities/rome800x600.jpg" alt="Rome" title="Rome" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>



        <?php include 'footer.php'; ?>

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/slimmenu.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-timepicker.js"></script>
        <script src="js/nicescroll.js"></script>
        <script src="js/dropit.js"></script>
        <script src="js/ionrangeslider.js"></script>
        <script src="js/icheck.js"></script>
        <script src="js/fotorama.js"></script>
        <script src="js/typeahead.js"></script>
        <script src="js/card-payment.js"></script>
        <script src="js/magnific.js"></script>
        <script src="js/owl-carousel.js"></script>
        <script src="js/fitvids.js"></script>
        <script src="js/tweet.js"></script>
        <script src="js/countdown.js"></script>
        <script src="js/gridrotator.js"></script>
        <script src="js/custom.js"></script>
    </div>
</body>

</html>


