<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }
if(empty($_SESSION['lang'])){ $lang = 'en_US'; }


include '../config.php';

require "localization.php";

if (!empty($_POST["origin"]) && !empty($_POST["destination"]) ) {

    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $pickupdate = $_POST['pickupdate'];
    $pickuptime = $_POST['pickuptime'];
    $price = $_POST['amount'];
    $item_name = $_POST['item_name'];
    $return = $_POST['return'];
    $seats = $_POST['seats'];
    $luggage = $_POST['luggage'];
    $services = $_POST['services'];
    $vehicles = $_POST['vehicles'];
    if (isset($_POST["vehicle"])) { $vehicle = $_POST['vehicle']; } else { $vehicle = "Not Specified"; }
    $chauffeursid = $_POST['chauffeursid'];

        if (!empty($_POST["returndate"]) && !empty($_POST["returntime"])) {
            $returndate = $_POST['returndate'];
            $returntime = $_POST['returntime'];
            $totalprice = $_POST['totalprice'];
        }

}


/* ----------------------- CHANGE IMGS FOR MOTO AND COACH -------------------------------------- */
if (isset($_POST["services"])) {
    if($_POST["services"] == 'ecocar') { $servicesname = _('Economy Car');
    $servicesimg = '<img src="../img/cars/peugeot508.png" alt="'.$servicesname.'" title="'.$servicesname.'" />';  }
    if($_POST["services"] == 'ecovan') { $servicesname = _('Economy Van');
    $servicesimg = '<img src="../img/cars/caravelle.png" alt="'.$servicesname.'" title="'.$servicesname.'" />'; }
    if($_POST["services"] == 'buscar') { $servicesname = _('Business Car');
    $servicesimg = '<img src="../img/cars/mbeclass.png" alt="'.$servicesname.'" title="'.$servicesname.'" />'; }
    if($_POST["services"] == 'busvan') { $servicesname = _('Business Van');
    $servicesimg = '<img src="../img/cars/mbviano.png" alt="'.$servicesname.'" title="'.$servicesname.'" />'; }
    if($_POST["services"] == 'luxcar') { $servicesname = _('First Class Car');
    $servicesimg = '<img src="../img/cars/mbsclass.png" alt="'.$servicesname.'" title="'.$servicesname.'" />'; }
    if($_POST["services"] == 'moto') { $servicesname = _('Motorcycle');
    $servicesimg = '<img src="../img/cars/bigger/moto.png" alt="'.$servicesname.'" title="'.$servicesname.'" />'; }
    if($_POST["services"] == 'coach') { $servicesname = _('Coach');
    $servicesimg = '<img src="../img/cars/bigger/bus.png" alt="'.$servicesname.'" title="'.$servicesname.'" />'; }

}


if(isset($_POST['booknow']))  {


    if(isset($_SESSION['id'])) {

      $sth = $bdd->prepare("SELECT * FROM clients WHERE id = :clientid");
        $sth->execute(array(':clientid' => $clientid));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
                      $pass = $result->pass;
                      $email = $result->email;
                      $first_name = $result->first_name;
                      $last_name = $result->last_name;
                      $phone = $result->last_name;

      include 'insertbooking.php';

    }

    if(isset($_POST['registration']) && $_POST['registration']==='accepted')  {



                /*

            START CLIENT REGISTRATION FORM ////////////////////////////////////////////////////////////////////////////////////////////


            */

              if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['night_phone_c'])
                  ) {
                extract($_POST);
                $valid = true;
                } else {
                 $valid = false;
                $erreuridd = _('Please fill in all the fields.');
                }


                if($valid)
                {

                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $email = $_POST['email'];
                    $phone = $_POST['night_phone_c'];
                    $pass = md5($_POST['pass']);




                  // check if email is valid
                  if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
                {

                // check if password is valid
                  if (preg_match("#^\S*(?=\S{6,30})(?=\S*[a-z])\S*$#", $_POST['pass']))
                {

                        /*
                        The requirements:

                        Must be a minimum of 8 characters
                        Must contain at least 1 number
                        Must contain at least one uppercase character
                        Must contain at least one lowercase character

                          ^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$
                        From the fine folks over at Zorched.

                        ^: anchored to beginning of string
                        \S*: any set of characters
                        (?=\S{8,}): of at least length 8
                        (?=\S*[a-z]): containing at least one lowercase letter
                        (?=\S*[A-Z]): and at least one uppercase letter
                        (?=\S*[\d]): and at least one number
                        $: anchored to the end of the string
                        To include special characters, just add (?=\S*[\W]), which is non-word characters.*/




                    // check if client email doesn't already exists

                    $req = $bdd->prepare('SELECT * FROM clients WHERE email=:email');
                  $req->execute(array(
                    'email'=>$email
                  ));
                  $data = $req->fetch();
                  if($req->rowCount()>0)
                  {
                    $valid = false;
                    $erreuridd = _('Email already exists. Please login or contact us.');
                  }


                  elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                    {


                        // if there not then insert into db
                        date_default_timezone_set('Europe/Madrid');
                          $date_inscription = date('Y-m-d H:i:s');


                          $reqq = $bdd->prepare('INSERT INTO clients (pass,email,date_inscription,first_name,last_name,phone) VALUES (:pass,:email,:date_inscription,:first_name,:last_name,:phone)');
                          $reqq->execute(array(
                            'pass'=>$pass,
                            'email'=>$email,
                            'date_inscription'=>$date_inscription,
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'phone'=>$phone

                          ));
                          $reqq->closeCursor();

                                    $email_subject = _('Your Registration on HopDriver');


                                      require_once('../PHPMailer_5.2.4/class.phpmailer.php');
                                //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

                                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

                                $mail->IsSMTP(); // telling the class to use SMTP

                                try {
                                  $mailmessage = file_get_contents('registrationclient_'.$lang.'.html');
                                  $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
                                  $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);

                                  $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
                                  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                  $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                  $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
                                  $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
                                  $mail->Username   = "78018976161272038a"; // SMTP account username
                                  $mail->Password   = "0a10a8b9a8dc1";        // SMTP account password
                                  $mail->AddAddress($email);
                                  $mail->SetFrom('contact@imagidev.com', 'HopDriver');
                                  $mail->AddReplyTo('contact@imagidev.com', 'HopDriver');
                                  $mail->AddBCC('contact@imagidev.com');
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

                             $req = $bdd->prepare('SELECT * FROM clients WHERE email=:email');
                          $req->execute(array(
                            'email'=>$email
                          ));
                           $data = $req->fetch();
                          $_SESSION['users'] = $email;
                          $_SESSION['id'] = $data['id'];
                          $id = $_SESSION['id'];
                          $req->closeCursor();

                          include 'insertbooking.php';

                            } //end elseif rowcount == 0

                          } // end if pass valid
                            else { $valid = false;
                            $erreuridd = _('Password must be at least 6 characters long.') . '<br />' . _('Contact us if you forgot it.'); } // end if email not valid

                            } //end if email valid

                             else { $valid = false;
                            $erreuridd = _('Invalid email.'); } // end if email not valid






                        } //end if valid
    } /* end registration accepted


            END CLIENT REGISTRATION FORM ////////////////////////////////////////////////////////////////////////////////////////////
            START CLIENT LOGIN //////////////////////////////////

            */
    elseif(isset($_POST['email_login'])) {

        if(!empty($_POST['email_login']) && !empty($_POST['pass_login'])
                  ) {
                extract($_POST);
                $valid = true;
                } else {
                 $valid = false;
                $erreuridd = _('Please fill in all the fields.');
                }


                if($valid)
                {

                    $pass = md5($_POST['pass_login']);
                    $email = $_POST['email_login'];

                      $req = $bdd->prepare('SELECT * FROM clients WHERE email=:email AND pass=:pass');
                      $req->execute(array(
                        'email'=>$email,
                        'pass'=>$pass
                      ));

                      $data = $req->fetch();
                      $id = $data->id;
                      $pass = $data->pass;
                      $email = $data->email;
                      $first_name = $data->first_name;
                      $last_name = $data->last_name;
                      $phone = $data->last_name;

                      if($req->rowCount()==0)
                      {
                        $valid = false;
                        $erreurid = _('Error ! Wrong email or password.');
                      }


                      else
                      {
                        if($req->rowCount()>0)
                        {
                          $_SESSION['users'] = $email;
                          $_SESSION['id'] = $data['id'];
                          $email = $data['email'];
                          $first_name = $data['first_name'];
                          $last_name = $data['last_name'];
                          $phone = $data['phone'];
                        }
                      }

                        $req->closeCursor();
                        if($valid)
                        {

                        include 'insertbooking.php';

                         }


                } // end valid
    } /* end if isset post login


            END CLIENT LOGIN FORM ////////////////////////////////////////////////////////////////////////////////////////////
            START INSERT BOOKING  //////////////////////////////////

            */





}  /* end booknow */


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _("Transfer Booking"); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('Transfer Booking'); ?>" />
    <meta name="description" content="HopDriver - <?php echo _('Transfer Booking'); ?>">
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


                                                     <?php if(isset($erreuridd)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $erreuridd; ?></p>
                                                        </div> <?php } ?>

                                                        <?php if(isset($erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $erreurid; ?></p>
                                                        </div> <?php } ?>


                        <?php include 'transfer-paypal-checkout.php'; ?>

                        </div>
                        <!--
                        <div class="col-md-6">
                            <h4>Pay via Credit/Debit Card</h4>
                            <form class="cc-form">
                                <div class="clearfix">
                                    <div class="form-group form-group-cc-number">
                                        <label>Card Number</label>
                                        <input class="form-control" placeholder="xxxx xxxx xxxx xxxx" type="text" /><span class="cc-card-icon"></span>
                                    </div>
                                    <div class="form-group form-group-cc-cvc">
                                        <label>CVC</label>
                                        <input class="form-control" placeholder="xxxx" type="text" />
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="form-group form-group-cc-name">
                                        <label>Cardholder Name</label>
                                        <input class="form-control" type="text" />
                                    </div>
                                    <div class="form-group form-group-cc-date">
                                        <label>Valid Thru</label>
                                        <input class="form-control" placeholder="mm/yy" type="text" />
                                    </div>
                                </div>
                                <div class="checkbox checkbox-small">
                                    <label>
                                        <input class="i-check" type="checkbox" checked/>Add to My Cards</label>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Proceed Payment" />
                            </form>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="booking-item-payment">
                        <header class="clearfix">
                            <a class="booking-item-payment-img" href="#">
                                <?php echo $servicesimg; ?>
                            </a>
                            <h5 class="booking-item-payment-title"><a href="#"><?php echo $servicesname; ?> <?php echo _('Transfer'); ?></h2></a></h5>
                        </header>
                        <ul class="booking-item-payment-details">
                            <li>
                                <h5><?php echo _("Transfer date"); ?></h5>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day"><?php echo $pickupdate; ?></p>
                                    <p class="booking-item-payment-date-weekday"><?php echo $pickuptime; ?></p>
                                <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day"><?php echo $returndate; ?></p>
                                    <p class="booking-item-payment-date-weekday"><?php echo $returntime; ?></p>
                                </div>
                                <?php } else { echo ""; } ?>
                            </li>
                            <li>
                                <h5><?php echo $servicesname; ?> (<?php echo $seats; ?> <?php echo _("Passengers"); ?>)</h5>
                                <ul class="booking-item-payment-price">
                                    <li>
                                        <p class="booking-item-payment-price-title"><?php echo _("One-way"); ?></p>
                                        <p class="booking-item-payment-price-amount"><?php echo $price; ?>€</p>
                                    </li>
                                    <?php if (!empty($returndate) && !empty($returntime)) { ?>
                                    <li>
                                        <p class="booking-item-payment-price-title"><?php echo _("Round-Trip"); ?></p>
                                        <p class="booking-item-payment-price-amount"><?php echo $totalprice; ?>€
                                        </p>
                                    </li>
                                    <?php } else { echo ""; } ?>
                                </ul>
                            </li>
                        </ul><?php if (!empty($returndate) && !empty($returntime)) { ?>
                        <p class="booking-item-payment-total"><?php echo _("Total"); ?>: <span><?php echo $totalprice; ?>€</span>
                        </p>
                        <?php } else {  ?>
                        <p class="booking-item-payment-total"><?php echo _("Total"); ?>: <span><?php echo $price; ?>€</span>
                        </p>
                        <?php } ?>
                    </div>
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
