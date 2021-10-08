<?php
session_start();
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }
if(empty($_SESSION['lang'])){ $lang = 'en_US'; }

require "localization.php";



include '../config.php';



if (isset($_GET['valid'])) {
    // On protège la variable "id_news" pour éviter une faille SQL
    $_GET['valid'] = addslashes($_GET['valid']);
    $id = $_GET['valid'];
    $accepted = 1;

    if (isset($_GET['driver'])) {


    $id_users = addslashes($_GET['driver']);




    $req = $bdd->prepare('UPDATE transfers_booking SET driverid = :id_users, accepted = :accepted WHERE id=:id');
    $req->execute(array(
      'id_users' => $id_users,
      'accepted' => $accepted,
      'id' => $id
    ));
    $req->closeCursor();


        $stt = $bdd->prepare("SELECT * FROM transfers_booking WHERE driverid = :id_users");
        $stt->execute(array(':id_users' => $id_users));
        $resultresa = $stt->fetch(PDO::FETCH_OBJ);
        $stt->closeCursor();
        $first_name = $resultresa->first_name;
        $last_name = $resultresa->last_name;
        $pickupdate = $resultresa->pickupdate;
        $pickuptime = $resultresa->pickuptime;
        $returndate = $resultresa->returndate;
        $returntime = $resultresa->returntime;
        $flightnumber = $resultresa->flightnumber;
        $origin = $resultresa->origin;
        $destination = $resultresa->destination;
        $phone = $resultresa->phone;
        $service = $resultresa->service;
        $comments = $resultresa->comments;
        $price = $resultresa->price;
        $clientid = $resultresa->clientid;
        $vehicle = $resultresa->vehicle;

        if (empty($vehicle)) { $vehicle = _(" "); }

        if(empty($returndate) && empty($returntime)) {
          $returndate = " - ";
          $returntime = " - ";
        }


     $sth = $bdd->prepare("SELECT first_name, last_name, email, phone, phonetwo, languages FROM chauffeurs WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;
        $driverphone = $result->phone;
        $driverphonetwo = $result->phonetwo;
        $driverlanguage = $result->languages;

      $ok = "";



      /* NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM

                  $email_subject = _('Accepted Transfer on').' '.$pickupdate.' '. _('at').' '.$pickuptime.' '.$price.'€';


                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('accept_'.$lang.'.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
              $mailmessage = str_replace('%driverfirst_name%', $driverfirst_name, $mailmessage);
              $mailmessage = str_replace('%pickupdate%', $pickupdate, $mailmessage);
              $mailmessage = str_replace('%pickuptime%', $pickuptime, $mailmessage);
              $mailmessage = str_replace('%returndate%', $returndate, $mailmessage);
              $mailmessage = str_replace('%returntime%', $returntime, $mailmessage);
              $mailmessage = str_replace('%flightnumber%', $flightnumber, $mailmessage);
              $mailmessage = str_replace('%origin%', $origin, $mailmessage);
              $mailmessage = str_replace('%phone%', $phone, $mailmessage);
              $mailmessage = str_replace('%destination%', $destination, $mailmessage);
              $mailmessage = str_replace('%service%', $service, $mailmessage);
              $mailmessage = str_replace('%comments%', $comments, $mailmessage);
              $mailmessage = str_replace('%price%', $price, $mailmessage);
              $mailmessage = str_replace('%vehicle%', $vehicle, $mailmessage);

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "780189161272038a"; // SMTP account username
              $mail->Password   = "0a10a8affe8dc1";        // SMTP account password
              $mail->AddAddress($driveremail);
              $mail->SetFrom('drivers@imagidev.com', 'HopDriver Drivers');
              $mail->AddReplyTo('drivers@imagidev.com', 'HopDriver Drivers');
              $mail->AddBCC('drivers@imagidev.com');
              $mail->Subject = $email_subject;
              $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
              $mail->MsgHTML($mailmessage);
              $mail->CharSet="UTF-8";

              // $mail->AddAttachment('images/phpmailer.gif');      // attachment
              // $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();

            } catch (phpmailerException $e) {
              echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              echo $e->getMessage(); //Boring error messages from anything else!
            }

            NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM */








            $sthh = $bdd->prepare("SELECT email FROM clients WHERE id = :clientid");
            $sthh->execute(array(':clientid' => $clientid));
            $result = $sthh->fetch(PDO::FETCH_OBJ);
            $sthh->closeCursor();
            $clientemail = $result->email;

                  $email_subject_client = _('Your driver for').' '.$pickupdate.' '. _('at').' '.$pickuptime.' '.$price.'€';


                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('client_notification_'.$lang.'.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
              $mailmessage = str_replace('%driverfirst_name%', $driverfirst_name, $mailmessage);
              $mailmessage = str_replace('%driverlast_name%', $driverlast_name, $mailmessage);
              $mailmessage = str_replace('%pickupdate%', $pickupdate, $mailmessage);
              $mailmessage = str_replace('%pickuptime%', $pickuptime, $mailmessage);
              $mailmessage = str_replace('%driverphone%', $driverphone, $mailmessage);
              $mailmessage = str_replace('%driverphonetwo%', $driverphonetwo, $mailmessage);
              $mailmessage = str_replace('%price%', $price, $mailmessage);
              $mailmessage = str_replace('%driverlanguage%', $driverlanguage, $mailmessage);
              $mailmessage = str_replace('%service%', $service, $mailmessage);

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "78011272038a"; // SMTP account username
              $mail->Password   = "0a10a84426affe8dc1";        // SMTP account password
              $mail->AddAddress($clientemail);
              $mail->SetFrom('contact@imagidev.com', 'HopDriver');
              $mail->AddReplyTo('contact@imagidev.com', 'HopDriver');
              $mail->AddBCC('contact@imagidev.com');
              $mail->Subject = $email_subject_client;
              $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
              $mail->MsgHTML($mailmessage);
              $mail->CharSet="UTF-8";

              // $mail->AddAttachment('images/phpmailer.gif');      // attachment
              // $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();

            } catch (phpmailerException $e) {
              echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              echo $e->getMessage(); //Boring error messages from anything else!
            }

        } // end if driver

} //end if valid


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('Transfer Accepted'); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('Transfer Accepted'); ?>" />
    <meta name="description" content="HopDriver - <?php echo _('Transfer Accepted'); ?>">
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
       <?php include '../header_transfers.php'; ?>


        <div class="gap"></div>


        <div class="container">
            <div class="row">
                <div class="col-md-8">


                        <h3><?php echo _('Transfer Accepted'); ?></h3>


                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo _('You accepted the transfer!'); ?><br /><?php echo _('You will receive an email with the details all of the client.'); ?></p>
                                                    </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-4">

                </div>
            </div>
            <div class="gap"></div>
        </div>



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
