<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }

require "localization.php";


if(isset($_POST['submit']))  {

     if(!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['message']))  {
        extract($_POST);
                $email = $_POST['email'];
                $name = $_POST['name'];
                $message = $_POST['message'];

    if(!empty($_POST['g-recaptcha-response']))  {
        extract($_POST);
                $captcha = $_POST['g-recaptcha-response'];


        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=987987&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if($response.success==false)
            {
                $erreurid = 'You are spammer ! Get the @$%K out';
            }

        else
            {


                  $to="contact@email.com";

                  // Extract form contents
                  $name = $_POST['name'];
                  $email = $_POST['email'];
                  $message = $_POST['message'];



                    $headers =  'Content-type: text/html; charset=utf-8'. "\r\n" .
                          'From: HopDriver <no-reply@email.com>'. "\r\n" .
                          'Reply-To: '.$email.'' . "\r\n" .
                          'X-Mailer: PHP/' . phpversion();
                    $email_subject = "Contact Form";
                    $message="Name: $name \n\nEmail: $email \n\nMessage:\n\n $message";


                     mail($to, $email_subject, $message, $headers);


                $ok = 'Email sent with success !';

            }

    } //if not empty captcha
        else {  $erreurid = 'Please check the captcha form'; }
    } //if not empty name email message
        else {  $erreurid = 'Please fill in the form correctly.'; }

} //submit


?>






<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _("Contact Us"); ?></title>


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
    <script src='https://www.google.com/recaptcha/api.js?hl=en'></script>


</head>

<body>
    <div class="global-wrap">
        <?php include 'header_contact.php'; ?>







        <div class="container">
            <h1 class="page-title"><?php echo _("Contact Us"); ?></h1>
            <div class="row">
                <div class="col-md-7">


                    <p><?php echo _("Fill in the form below if you have any questions regarding your reservation or other and we'll get back to you within 24 hours."); ?></p>

                     <?php if(isset($ok)){ echo '<p id="ok">'.$ok.'</p>';}
            elseif(isset($erreurid)){  echo '<p id="erreurid">'.$erreurid.'</p>'; } ?>

                    <form class="mt30" action="contact.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _("Name"); ?></label>
                                    <input name="name" class="form-control" type="text" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _("E-mail"); ?></label>
                                    <input name="email" class="form-control" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _("Message"); ?></label>
                            <textarea name="message" class="form-control"></textarea>
                            <br />
                            <div class="g-recaptcha" data-sitekey="6LcXD31Szk"></div>
                        </div>

                        <input class="btn btn-primary" name="submit" type="submit" value="Send Message" />
                    </form>
                </div>
                <div class="col-md-4">
                    <aside class="sidebar-right">
                        <ul class="address-list list">
                            <li>
                                <h5><?php echo _("Email"); ?></h5><a href="#">contact@email.com</a>
                            </li>
                            <li>
                                <h5><?php echo _("Phone"); ?> - <?php echo _("Available 24/7"); ?></h5><a href="#">+33 9 77 55 52 55</a>
                            </li>
                            <li>
                                <h5><?php echo _("Address"); ?></h5><address>Voklee<br />11 rue de Adresse<br />75000 Paris<br />France<br /></address>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
            <div class="gap"></div>
        </div>

        <div id="map-canvas" style="height:400px;"></div> <!-- to modify latitude or longitude js/custom.js #map-canvas -->



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
    <script src="//maps.googleapis.com/maps/api/js?key=DHVg&libraries=places&language=en"></script>
    <!-- <script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&language=en"></script> -->
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
