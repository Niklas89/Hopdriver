<?php

session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
  header('Location: login.php');
  exit();
}



include '../config.php';


    $disposalid = $_GET['id'];


    $sth = $bdd->prepare('SELECT * FROM disposal_booking WHERE id=\'' . $disposalid . '\' ');
        $sth->execute(array(':disposalid' => $disposalid));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $coldate = $result->coldate;
        $service = $result->service;
        $pickupdate = $result->pickupdate;
        $pickuptime = $result->pickuptime;
        $drop_off_date = $result->drop_off_date;
        $drop_off_time = $result->drop_off_time;
        $pick_up_loc = $result->pick_up_loc;
        $drop_off_loc = $result->drop_off_loc;
        $first_name = $result->first_name;
        $last_name = $result->last_name;
        $flightnumber = $result->flightnumber;
        $email = $result->email;
        $phone = $result->phone;
        $price = $result->price;
        $hoursday = $result->hoursday;
        $promo = $result->promo;
        $comments = $result->comments;
        $driverid = $result->driverid;
        $clientid = $result->clientid;


    if (isset($_POST["disposal-cars"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['night_phone_c'];
    $flightnumber = $_POST['custom'];
    $service = $_POST['item_name'];
    $price = $_POST['amount'];
    $pick_up_loc = $_POST['pick_up_loc'];
    $drop_off_loc = $_POST['drop_off_loc'];
    $pickupdate = $_POST['start'];
    $pickuptime = $_POST['pickuptime'];
    $drop_off_date = $_POST['drop_off_date'];
    $drop_off_time = $_POST['drop_off_time'];
    $hoursday = $_POST['hoursday'];
    $agency_email = $_POST['agency_email'];
    $comments =  $_POST['comments'];
    $driverid = 0; // open to all drivers
    $accepted = 1; // transfer confirmed to agency

    date_default_timezone_set('Europe/Madrid');
    $coldate = date('Y-m-d H:i:s');


    $sth = $bdd->prepare("SELECT id, first_name FROM clients WHERE email = :agency_email");
        $sth->execute(array(':agency_email' => $agency_email));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $agency_id = $result->id;
        $agentfirst_name = $result->first_name;


    $req = $bdd->prepare('UPDATE disposal_booking SET first_name = :first_name, last_name = :last_name, pickupdate = :pickupdate, pickuptime = :pickuptime,
      flightnumber = :flightnumber, email = :email, phone = :phone, service = :service, pick_up_loc = :pick_up_loc, drop_off_loc = :drop_off_loc,
      drop_off_date = :drop_off_date, drop_off_time = :drop_off_time, price = :price, hoursday = :hoursday, comments = :comments, driverid = :driverid,
      clientid = :agency_id, accepted = :accepted WHERE id = :disposalid');
    $req->execute(array(

        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'pickupdate'=>$pickupdate,
        'pickuptime'=>$pickuptime,
        'flightnumber'=>$flightnumber,
        'email'=>$email,
        'phone'=>$phone,
        'service'=>$service,
        'pick_up_loc'=>$pick_up_loc,
        'drop_off_loc'=>$drop_off_loc,
        'drop_off_date'=>$drop_off_date,
        'drop_off_time'=>$drop_off_time,
        'price'=>$price,
        'hoursday'=>$hoursday,
        'comments'=>$comments,
        'driverid'=>$driverid,
        'agency_id'=>$agency_id,
        'accepted'=>$accepted,
        'disposalid' => $disposalid
    ));
    $req->closeCursor();

    /*$req = $bdd->prepare('INSERT INTO disposal_booking (coldate,first_name,last_name,pickupdate,pickuptime,flightnumber,email,phone,service,pick_up_loc,drop_off_loc,drop_off_date,drop_off_time,price,hoursday,promo,comments,driverid,clientid,accepted)
        VALUES (:coldate,:first_name,:last_name,:pickupdate,:pickuptime,:flightnumber,:email,:phone,:service,:pick_up_loc,:drop_off_loc,:drop_off_date,:drop_off_time,:price,:hoursday,:promo,:comments,:driverid,:agency_id,:accepted)');
      $req->execute(array(
        'coldate'=>$coldate,
        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'pickupdate'=>$pickupdate,
        'pickuptime'=>$pickuptime,
        'flightnumber'=>$flightnumber,
        'email'=>$email,
        'phone'=>$phone,
        'service'=>$service,
        'pick_up_loc'=>$pick_up_loc,
        'drop_off_loc'=>$drop_off_loc,
        'drop_off_date'=>$drop_off_date,
        'drop_off_time'=>$drop_off_time,
        'price'=>$price,
        'hoursday'=>$hoursday,
        'promo'=>$promo,
        'comments'=>$comments,
        'driverid'=>$driverid,
        'agency_id'=>$agency_id,
        'accepted'=>$accepted,


      ));
      $req->closeCursor();*/


                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('editeddisposal.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
              $mailmessage = str_replace('%agentfirst_name%', $agentfirst_name, $mailmessage);
              $mailmessage = str_replace('%pickupdate%', $pickupdate, $mailmessage);
              $mailmessage = str_replace('%pickuptime%', $pickuptime, $mailmessage);
              $mailmessage = str_replace('%flightnumber%', $flightnumber, $mailmessage);
              $mailmessage = str_replace('%pick_up_loc%', $pick_up_loc, $mailmessage);
              $mailmessage = str_replace('%drop_off_loc%', $drop_off_loc, $mailmessage);
              $mailmessage = str_replace('%drop_off_date%', $drop_off_date, $mailmessage);
              $mailmessage = str_replace('%drop_off_time%', $drop_off_time, $mailmessage);
              $mailmessage = str_replace('%hoursday%', $hoursday, $mailmessage);
              $mailmessage = str_replace('%phone%', $phone, $mailmessage);
              $mailmessage = str_replace('%service%', $service, $mailmessage);
              $mailmessage = str_replace('%comments%', $comments, $mailmessage);
              $mailmessage = str_replace('%price%', $price, $mailmessage);

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "780189761272038a"; // SMTP account username
              $mail->Password   = "0a10afe8dc1";        // SMTP account password
              $mail->AddAddress($agency_email);
              $mail->SetFrom('bookings@imagidev.com', 'Voklee Bookings');
              $mail->AddReplyTo('bookings@imagidev.com', 'Voklee Bookings');
              $mail->AddBCC('bookings@imagidev.com');
              $mail->Subject = 'Disposal confirmed';
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

              $driversend = $bdd->query("SELECT email,first_name FROM chauffeurs WHERE '".$pick_up_loc."' LIKE CONCAT('%', country, '%')");
                                 $driversend->setFetchMode(PDO::FETCH_OBJ);
                                  while($result = $driversend->fetch()) {


                                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('new-disposal-drivers.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
              $mailmessage = str_replace('%drivername%', $result->first_name, $mailmessage);
              $mailmessage = str_replace('%pickupdate%', $pickupdate, $mailmessage);
              $mailmessage = str_replace('%pickuptime%', $pickuptime, $mailmessage);
              $mailmessage = str_replace('%flightnumber%', $flightnumber, $mailmessage);
              $mailmessage = str_replace('%pick_up_loc%', $pick_up_loc, $mailmessage);
              $mailmessage = str_replace('%drop_off_loc%', $drop_off_loc, $mailmessage);
              $mailmessage = str_replace('%drop_off_date%', $drop_off_date, $mailmessage);
              $mailmessage = str_replace('%drop_off_time%', $drop_off_time, $mailmessage);
              $mailmessage = str_replace('%hoursday%', $hoursday, $mailmessage);
              $mailmessage = str_replace('%phone%', $phone, $mailmessage);
              $mailmessage = str_replace('%service%', $service, $mailmessage);
              $mailmessage = str_replace('%comments%', $comments, $mailmessage);

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "78018038a"; // SMTP account username
              $mail->Password   = "0a10ae8dc1";        // SMTP account password


              $mail->AddAddress($result->email);


              $mail->SetFrom('drivers@imagidev.com', 'Voklee Drivers');
              $mail->AddReplyTo('drivers@imagidev.com', 'Voklee Drivers');
              $mail->Subject = 'New Disposal';
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



      header('Location: disposaldetails.php?id='.$disposalid);

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
            <h1 class="page-title">Edit Disposal</h1>
        </div>

        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                            <div class="col-md-8">
                                                        <form action="editdisposal.php?id=<?php echo $disposalid; ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>Start Location</label>
                                                                            <input class="typeahead form-control" value="<?php if (!empty($pick_up_loc)) { echo $pick_up_loc; } else { echo ""; } ?>" placeholder="City, Airport, Zip Code" type="text" name="pick_up_loc" id="autocomplete" onclick="initializer()" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>End Location</label>
                                                                            <input class="typeahead form-control" value="<?php if (!empty($drop_off_loc)) { echo $drop_off_loc; } else { echo ""; } ?>" placeholder="City, Airport, Zip Code" type="text"  name="drop_off_loc" id="autocompletee" onclick="initialize()" onFocus="geolocate()"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="input-daterange" data-date-format="d M yyyy">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label>Start Date</label>
                                                                                <input class="form-control" value="<?php if (!empty($pickupdate)) { echo $pickupdate; } else { echo ""; } ?>" name="start" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Start Time</label>
                                                                                <input class="time-pick form-control" value="<?php if (!empty($pickuptime)) { echo $pickuptime; } else { echo "12:00 AM"; } ?>" name="pickuptime" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label>End Date</label>
                                                                                <input class="form-control" value="<?php echo $drop_off_date; ?>" name="drop_off_date" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>End Time</label>
                                                                                <input class="time-pick form-control" value="<?php echo $drop_off_time; ?>" name="drop_off_time" type="text" />
                                                                            </div>
                                                                        </div>
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
                                                                        <div class="row">

                                                                                <div class="col-md-3">
                                                                                    <div class="form-group form-group-lg form-group-select-plus">
                                                                                        <label>Hours / day</label>
                                                                                        <div class="btn-group btn-group-select-num hidden" data-toggle="buttons">
                                                                                            <label class="btn btn-primary active">
                                                                                                <input type="radio" name="options" />1</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options" />2</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options" />3</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options"  />4</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options" />5</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options" />6</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options"  />7</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options" />8</label>
                                                                                            <label class="btn btn-primary">
                                                                                                <input type="radio" name="options" />8+</label>
                                                                                        </div>
                                                                                        <select name="hoursday" class="form-control" >
                                                                                            <option><?php if (!empty($hoursday)) { echo $hoursday; } else { echo "Choose"; } ?></option>
                                                                                            <option>1</option>
                                                                                            <option >2</option>
                                                                                            <option >3</option>
                                                                                            <option >4</option>
                                                                                            <option >5</option>
                                                                                            <option >6</option>
                                                                                            <option >7</option>
                                                                                            <option >8</option>
                                                                                            <option >9</option>
                                                                                            <option >10</option>
                                                                                            <option >11</option>
                                                                                            <option >12</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                        </div> <!-- end fith row -->
                                                                            <button class="btn btn-primary btn-lg" type="submit"  name="disposal-cars">Confirm to drivers & agencies</button>
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
