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



include '../config.php';

// if get valid la case "driverid" de la table "annonces" est egal a lid du pseudo qui la accepté -> lannonce ne se montre pas pour les autres id

$sth = $bdd->prepare("SELECT first_name, last_name, email, country FROM chauffeurs WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;
        $drivercountry = $result->country;

  if (isset($_GET['valid'])) {
    // On protège la variable "id_news" pour éviter une faille SQL
    $_GET['valid'] = addslashes($_GET['valid']);
    $id = $_GET['valid'];
    $accepted = 1;





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



      /*  NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM

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
              $mail->Username   = "7801897cd6161272038a"; // SMTP account username
              $mail->Password   = "0a10a8b9aaffe8dc1";        // SMTP account password
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
              $mail->Username   = "780189cd6161272038a"; // SMTP account username
              $mail->Password   = "0a10a8b9a3a4ffe8dc1";        // SMTP account password
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



} //end if valid


  if (isset($_GET['cancel'])) {
    // On protège la variable "id_news" pour éviter une faille SQL
    $_GET['cancel'] = addslashes($_GET['cancel']);
    $id = $_GET['cancel'];
    $id_cancel = 0;



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
        $vehicle = $resultresa->vehicle;

        if (empty($vehicle)) { $vehicle = _(" "); }

        if(empty($returndate) && empty($returntime)) {
          $returndate = " - ";
          $returntime = " - ";
        }


     $sth = $bdd->prepare("SELECT first_name, last_name, email FROM chauffeurs WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;

      $ok = "";




      /*  NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM

                  $email_subject = _('Canceled Transfer on').' '.$pickupdate.' '. _('at').' '.$pickuptime;


                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('cancel_'.$lang.'.html');
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
              $mail->Username   = "780189720272038a"; // SMTP account username
              $mail->Password   = "0a10a8b9a3a4ffe8dc1";        // SMTP account password
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



             NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM   */



    $req = $bdd->prepare('UPDATE transfers_booking SET driverid = :id_cancel, accepted = :id_cancel WHERE id=:id');
    $req->execute(array(
      'id_cancel' => $id_cancel,
      'id' => $id
    ));
    $req->closeCursor();
}





///////////////////////////////////// PAGINATION ////////////////////////////////////////

$messagesParPage=10; //Nous allons afficher 5 messages par page.

//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM transfers_booking WHERE accepted=0 OR (accepted=1 AND driverid='.$id_users.') AND origin LIKE "%'.$drivercountry.'%"');
$retour_total->setFetchMode(PDO::FETCH_OBJ); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total = $retour_total->fetch(); //On range retour sous la forme d'un tableau.
$total=$donnees_total->total; //On récupère le total pour le placer dans la variable $total.

//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);

     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1
}





?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('New Transfers'); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('airport transfers, private transfer, HopDriver, disposal services'); ?>" />
    <meta name="description" content="<?php echo _('HopDriver - private transfers and disposal services'); ?>">
    <meta name="author" content="Niklas Edelstam">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS  -->
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
            <h1 class="page-title"><?php echo _('New Transfers'); ?></h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />--><?php echo _('Accept transfers in the list below'); ?>:</label>
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


                  $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire







                              // La requête sql pour récupérer les messages de la page actuelle.
                              $retour_messages=$bdd->query('SELECT * FROM transfers_booking WHERE accepted=0 OR (accepted=1 AND driverid='.$id_users.') AND  origin LIKE "%'.$drivercountry.'%" ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
                              $retour_messages->setFetchMode(PDO::FETCH_OBJ);
                              while( $resultat = $retour_messages->fetch() )
                              {

                                //example: if( strpos($a, 'some text') !== false ) {echo "match";}  (check if string contains certain word)
                                 //if( strpos($resultat->origin, $drivercountry) !== false ) echo "match";



                                ?>


                                        <tr>
                                            <td class="booking-history-title"><?php echo $resultat->service; ?>
                                            </td>
                                            <td><?php echo $resultat->origin; ?></td>
                                            <td><?php echo $resultat->destination; ?></td>
                                            <td><?php echo $resultat->pickupdate; ?></td>
                                            <td><?php echo $resultat->pickuptime; ?></td>
                                            <td><a class="btn btn-info btn-sm" href="transferdetails.php?id=<?php echo $resultat->id; ?>" title="<?php echo _('More details'); ?>"><?php echo _('Infos'); ?></a></td>                                            <?php if ($resultat->accepted == 1 ) { ?>
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
                              $retour_messages->closeCursor();



                              ?>
                        </tbody>
                    </table>
                    <?php
                    echo '<p align="center">'; //Pour l'affichage, on centre la liste des pages
                              //if($nombreDePages>9) {$nombreDePages=9;} // si on a juste les chiffres qui s'affichent ///////


                             // if($nombreDePages>$nombreDePagesMax){ echo ' ...<a href="#">Booking History</a>'; }

                                if($pageActuelle > 1 && $pageActuelle <= $nombreDePages){
                                    $precedent = $pageActuelle-1;
                                    echo '<a href="'.$thispage.'?page=1" /> << </a> - ';
                                    echo '<a href="'.$thispage.'?page='.$precedent.'" /> '.$precedent.' </a> - ';
                                }

                                for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                              {
                                   //On va faire notre condition
                                   if($i==$pageActuelle) //Si il s'agit de la page actuelle...
                                   {
                                       echo '[ '.$i.' ] ';
                                   }
                                   /*else
                                   {
                                        echo ' <a href="transfers.php?page='.$i.'">'.$i.'</a> ';
                                   }*/
                              }
                                if($pageActuelle >= 1 && $pageActuelle <= $nombreDePages-1){
                                    $suivant = $pageActuelle+1;
                                    echo ' - <a href="'.$thispage.'?page='.$suivant.'" />'.$suivant.' </a> ';
                                    echo ' - <a href="'.$thispage.'?page='.$nombreDePages.'" /> >> </a>';
                                }
                         echo '</p>';

                              ?>
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
