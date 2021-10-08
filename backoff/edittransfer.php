<?php

session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
  header('Location: login.php');
  exit();
}



include '../config.php';


    $transferid = $_GET['id'];


    $sth = $bdd->prepare('SELECT * FROM transfers_booking WHERE id=\'' . $transferid . '\' ');
        $sth->execute(array(':transferid' => $transferid));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $coldate = $result->coldate;
        $service = $result->service;
        $pickupdate = $result->pickupdate;
        $pickuptime = $result->pickuptime;
        $returndate = $result->returndate;
        $returntime = $result->returntime;
        $origin = $result->origin;
        $destination = $result->destination;
        $first_name = $result->first_name;
        $last_name = $result->last_name;
        $flightnumber = $result->flightnumber;
        $email = $result->email;
        $phone = $result->phone;
        $price = $result->price;
        $promo = $result->promo;
        $comments = $result->comments;
        $driverid = $result->driverid;
        $clientid = $result->clientid;


    if (isset($_POST["transfer-services"]) && !empty($_POST["end"]) && !empty($_POST["returntime"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['night_phone_c'];
    $flightnumber = $_POST['custom'];
    $service = $_POST['item_name'];
    $price = $_POST['amount'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $pickupdate = $_POST['start'];
    $pickuptime = $_POST['pickuptime'];
    $comments = $_POST['comments'];
    $agency_email = $_POST['agency_email'];
    $driverid = 0; // open to all drivers
    $accepted = 1; // transfer confirmed to agency

    date_default_timezone_set('Europe/Madrid');
    $coldate = date('Y-m-d H:i:s');

    $returndate = $_POST['end'];
    $returntime = $_POST['returntime'];


    $sth = $bdd->prepare("SELECT id, first_name FROM clients WHERE email = :agency_email");
        $sth->execute(array(':agency_email' => $agency_email));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $agency_id = $result->id;
        $agentfirst_name = $result->first_name;




      $req = $bdd->prepare('UPDATE transfers_booking SET first_name = :first_name, last_name = :last_name, pickupdate = :pickupdate, pickuptime = :pickuptime,
      flightnumber = :flightnumber, email = :email, phone = :phone, service = :service, origin = :origin, destination = :destination,
      returndate = :returndate, returntime = :returntime, price = :price, comments = :comments, driverid = :driverid,
      clientid = :agency_id, accepted = :accepted WHERE id = :transferid');
    $req->execute(array(

        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'pickupdate'=>$pickupdate,
        'pickuptime'=>$pickuptime,
        'flightnumber'=>$flightnumber,
        'email'=>$email,
        'phone'=>$phone,
        'service'=>$service,
        'origin'=>$origin,
        'destination'=>$destination,
        'returndate'=>$returndate,
        'returntime'=>$returntime,
        'price'=>$price,
        'comments'=>$comments,
        'driverid'=>$driverid,
        'agency_id'=>$agency_id,
        'accepted'=>$accepted,
        'transferid' => $transferid
    ));
    $req->closeCursor();


                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('editedtransfer.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
              $mailmessage = str_replace('%agentfirst_name%', $agentfirst_name, $mailmessage);
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

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "7801892038a"; // SMTP account username
              $mail->Password   = "0a10a8affe8dc1";        // SMTP account password
              $mail->AddAddress($agency_email);
              $mail->SetFrom('bookings@imagidev.com', 'Voklee Bookings');
              $mail->AddReplyTo('bookings@imagidev.com', 'Voklee Bookings');
              $mail->AddBCC('bookings@imagidev.com');
              $mail->Subject = 'Transfer confirmed';
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



                               //////// mail envoyé à tous les chauffeurs ////////////////////////////////////////////////////////////////////////////////////////////////////

                                $driversend = $bdd->query("SELECT email,first_name FROM chauffeurs WHERE '".$origin."' LIKE CONCAT('%', country, '%')");
                                 $driversend->setFetchMode(PDO::FETCH_OBJ);
                                  while($result = $driversend->fetch()) {


                                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

                                $mail->IsSMTP(); // telling the class to use SMTP

                                try {
                                  $mailmessage = file_get_contents('new-transfer-drivers.html');
                                  $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
                                  $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
                                  $mailmessage = str_replace('%drivername%', $result->first_name, $mailmessage);
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

                                  $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
                                  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                  $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                  $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
                                  $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
                                  $mail->Username   = "78012038a"; // SMTP account username
                                  $mail->Password   = "0a10a8e8dc1";        // SMTP account password

                                      $mail->AddAddress($result->email);

                                  $mail->SetFrom('drivers@imagidev.com', 'Voklee Drivers');
                                  $mail->AddReplyTo('drivers@imagidev.com', 'Voklee Drivers');
                                  $mail->Subject = 'New Transfer';
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

                              } // end while
                                   $driversend->closeCursor();



      header('Location: transferdetails.php?id='.$transferid);


    } // end if not empty return
    if(isset($_POST["transfer-services"]) && empty($_POST["end"]) && empty($_POST["returntime"])) {
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $pickupdate = $_POST['start'];
        $pickuptime = $_POST['pickuptime'];
        $comments = $_POST['comments'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['night_phone_c'];
        $flightnumber = $_POST['custom'];
        $service = $_POST['item_name'];
        $price = $_POST['amount'];
        $agency_email = $_POST['agency_email'];
        $driverid = 0; // open to all drivers
        $accepted = 1; // transfer confirmed to agency

        date_default_timezone_set('Europe/Madrid');
        $coldate = date('Y-m-d H:i:s');

        $returndate = " - ";
        $returntime = " - ";


        $sth = $bdd->prepare("SELECT id, first_name FROM clients WHERE email = :agency_email");
        $sth->execute(array(':agency_email' => $agency_email));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $agency_id = $result->id;
        $agentfirst_name = $result->first_name;


        $req = $bdd->prepare('UPDATE transfers_booking SET first_name = :first_name, last_name = :last_name, pickupdate = :pickupdate, pickuptime = :pickuptime,
      flightnumber = :flightnumber, email = :email, phone = :phone, service = :service, origin = :origin, destination = :destination,
      returndate = :returndate, returntime = :returntime, price = :price, comments = :comments, driverid = :driverid,
      clientid = :agency_id, accepted = :accepted WHERE id = :transferid');
    $req->execute(array(

        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'pickupdate'=>$pickupdate,
        'pickuptime'=>$pickuptime,
        'flightnumber'=>$flightnumber,
        'email'=>$email,
        'phone'=>$phone,
        'service'=>$service,
        'origin'=>$origin,
        'destination'=>$destination,
        'returndate'=>$returndate,
        'returntime'=>$returntime,
        'price'=>$price,
        'comments'=>$comments,
        'driverid'=>$driverid,
        'agency_id'=>$agency_id,
        'accepted'=>$accepted,
        'transferid' => $transferid
    ));
    $req->closeCursor();

                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('editedtransfer.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
              $mailmessage = str_replace('%agentfirst_name%', $agentfirst_name, $mailmessage);
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

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "780189272038a"; // SMTP account username
              $mail->Password   = "0a10a8ffe8dc1";        // SMTP account password
              $mail->AddAddress($agency_email);
              $mail->SetFrom('bookings@imagidev.com', 'Voklee Bookings');
              $mail->AddReplyTo('bookings@imagidev.com', 'Voklee Bookings');
              $mail->AddBCC('bookings@imagidev.com');
              $mail->Subject = 'Transfer confirmed';
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



                               //////// mail envoyé à tous les chauffeurs ////////////////////////////////////////////////////////////////////////////////////////////////////

                                $driversend = $bdd->query("SELECT email,first_name FROM chauffeurs WHERE '".$origin."' LIKE CONCAT('%', country, '%')");
                                 $driversend->setFetchMode(PDO::FETCH_OBJ);
                                  while($result = $driversend->fetch()) {


                                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

                                $mail->IsSMTP(); // telling the class to use SMTP

                                try {
                                  $mailmessage = file_get_contents('new-transfer-drivers.html');
                                  $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
                                  $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
                                  $mailmessage = str_replace('%drivername%', $result->first_name, $mailmessage);
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

                                  $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
                                  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                  $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                  $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
                                  $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
                                  $mail->Username   = "7801892038a"; // SMTP account username
                                  $mail->Password   = "0a10ffe8dc1";        // SMTP account password

                                      $mail->AddAddress($result->email);

                                  $mail->SetFrom('drivers@imagidev.com', 'Voklee Drivers');
                                  $mail->AddReplyTo('drivers@imagidev.com', 'Voklee Drivers');
                                  $mail->Subject = 'New Transfer';
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

                              } // end while
                                   $driversend->closeCursor();



          header('Location: transferdetails.php?id='.$transferid);

    }


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Voklee - User Profile</title>


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
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&language=en"></script>
    <script src="../calcul-itineraire/autocomplete.js"></script>


</head>

<body>


    <div class="global-wrap">

        <?php include '../header_partners.php'; ?>

        <div class="container">
            <h1 class="page-title">Edit Transfer</h1>
        </div>

        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                            <div class="col-md-8">
                                                        <form action="edittransfer.php?id=<?php echo $transferid; ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>From</label>
                                                                            <input class="typeahead form-control" value="<?php if (!empty($origin)) { echo $origin; } else { echo ""; } ?>" placeholder="City, Airport, Zip Code" type="text" name="origin" id="autocomplete" onclick="initializer()" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>To</label>
                                                                            <input class="typeahead form-control" value="<?php if (!empty($destination)) { echo $destination; } else { echo ""; } ?>" placeholder="City, Airport, Zip Code" type="text"  name="destination" id="autocompletee" onclick="initialize()" onFocus="geolocate()"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="input-daterange" data-date-format="d M yyyy">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label>Pick-up Date</label>
                                                                                <input class="form-control" value="<?php if (!empty($pickupdate)) { echo $pickupdate; } else { echo ""; } ?>" name="start" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Pick-up Time</label>
                                                                                <input class="time-pick form-control" value="<?php if (!empty($pickuptime)) { echo $pickuptime; } else { echo "12:00 AM"; } ?>" name="pickuptime" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <?php if (!empty($returndate)) { ?>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label>Return Date</label>
                                                                                <input class="form-control" value="<?php echo $returndate; ?>" name="end" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                        <?php if (!empty($returntime)) { ?>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Return Time</label>
                                                                                <input class="time-pick form-control" value="<?php echo $returntime; ?>" name="returntime" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div> <!-- end first row -->
                                                                    <div class="row">
                                                                            <div class="col-md-9">
                                                                                <div class="form-group">
                                                                                    <label>Full Description</label>
                                                                                    <textarea rows="5" cols="70" name="comments" id="comments" class="form-control" type="textarea" /><?php if (!empty($comments)) { echo $comments; } else { echo "Type all the details about your booking here."; } ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group form-group-lg form-group-select-plus">
                                                                                    <label>Service</label>
                                                                                    <select name="item_name" class="form-control" >
                                                                                        <option><?php if (!empty($service)) { echo $service; } else { echo "Choose Service"; } ?></option>
                                                                                        <option >Economy Car</option>
                                                                                        <option >Economy Van</option>
                                                                                        <option >Business Car</option>
                                                                                        <option >Business Van</option>
                                                                                        <option >Luxury Car</option>
                                                                                        <option >Bus/Coach</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Transfer Price</label>
                                                                                    <input value="<?php if (!empty($price)) { echo $price; } else { echo ""; } ?>" name="amount" id="amount" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                    </div> <!-- end second row -->
                                                                    <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>First Name</label>
                                                                                    <input value="<?php if (!empty($first_name)) { echo $first_name; } else { echo ""; } ?>" name="first_name" id="first_name" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>Last Name</label>
                                                                                    <input value="<?php if (!empty($last_name)) { echo $last_name; } else { echo ""; } ?>" name="last_name" id="last_name" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>E-mail</label>
                                                                                    <input class="form-control" value="<?php if (!empty($email)) { echo $email; } else { echo ""; } ?>" name="email" id="email" type="text" />
                                                                                </div>
                                                                            </div>
                                                                    </div> <!-- end third row -->
                                                                    <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>Phone Number (with country code)</label>
                                                                                    <input value="<?php if (!empty($phone)) { echo $phone; } else { echo ""; } ?>" name="night_phone_c" id="night_phone_c" class="form-control" type="text" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>Flightnumber</label>
                                                                                    <input value="<?php if (!empty($flightnumber)) { echo $flightnumber; } else { echo ""; } ?>" name="custom" id="custom" class="form-control" type="text" />
                                                                                    </div>
                                                                                </div>

                                                                                <?php

                                                                                $sth = $bdd->prepare("SELECT email FROM clients WHERE id = :clientid");
                                                                                $sth->execute(array(':clientid' => $clientid));
                                                                                $result = $sth->fetch(PDO::FETCH_OBJ);
                                                                                $sth->closeCursor();
                                                                                $agency_email = $result->email;



                                                                                ?>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label>Agency Email</label>
                                                                                        <input class="form-control" value="<?php if (!empty($agency_email)) { echo $agency_email; } else { echo ""; } ?>" name="agency_email" id="agency_email" type="text" />
                                                                                    </div>
                                                                                </div>


                                                                        </div> <!-- end fourth row -->
                                                                            <button class="btn btn-primary btn-lg" type="submit"  name="transfer-services">Confirm to drivers & agencies</button>
                                                                        </form>



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
