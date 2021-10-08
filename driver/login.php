<?php
session_start();
if(!empty($_SESSION['id']))
{

  $id_users = $_SESSION['id'];
    $email =  $_SESSION['users'];


  include '../config.php';
  include 'function.php';


  echo getDriverStart();
}

if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }
if(empty($_SESSION['lang'])){ $lang = 'en_US'; }

require "localization.php";


/*

    START LOGIN PROCESS ////////////////////////////////////////////////////////////////////////////////////////////


    */

if(isset($_POST['login']))
{
  $valid = true;
  extract($_POST);

  if($valid)
  {

    include '../config.php';





 $pass = md5($_POST['pass']);

  $req = $bdd->prepare('SELECT * FROM chauffeurs WHERE email=:email AND pass=:pass');
  $req->execute(array(
    'email'=>$email,
    'pass'=>$pass
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = _('Please fill in the form correctly.');
  }


  else
  {
    if($req->rowCount()>0)
    {
      $_SESSION['users'] = $email;
      $_SESSION['id'] = $data['id'];
    }
  }

    $req->closeCursor();
    if($valid)
    {
      header('Location: profile.php');
    }


} // end valid
} // end post login







if(isset($_POST['register']))  {


/*

    START DRIVER REGISTRATION FORM ////////////////////////////////////////////////////////////////////////////////////////////


    */

  if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['pass'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $erreuridd = _('Please fill in all the fields.');
    }


    if($valid)
    {



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

        include '../config.php';



        // check if driver email doesn't already exists
        $email = $_POST['email'];

        $req = $bdd->prepare('SELECT email FROM chauffeurs WHERE email=:email');
      $req->execute(array(
        'email'=>$email
      ));
      $data = $req->fetch();
      if($req->rowCount()>0)
      {
        $valid = false;
        $erreuridd = _('This driver already exists.');
      }


      elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
        {






          // if there not then insert into db
    date_default_timezone_set('Europe/Madrid');
      $date_inscription = date('Y-m-d H:i:s');

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $pass = md5($_POST['pass']);
        $company = $first_name." ".$last_name;


      $reqq = $bdd->prepare('INSERT INTO chauffeurs (pass,email,date_inscription,first_name,last_name,company) VALUES (:pass,:email,:date_inscription,:first_name,:last_name,:company)');
      $reqq->execute(array(
        'pass'=>$pass,
        'email'=>$email,
        'date_inscription'=>$date_inscription,
        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'company'=>$company

      ));
      $reqq->closeCursor();




      /* NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM




                  $email_subject = _('Your Registration as Driver on HopDriver');

                  require_once('../PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('registration_'.$lang.'.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "78018961272038a"; // SMTP account username
              $mail->Password   = "0a10a8bfe8dc1";        // SMTP account password
              $mail->AddAddress($email);
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

         $req = $bdd->prepare('SELECT * FROM chauffeurs WHERE email=:email');
      $req->execute(array(
        'email'=>$email
      ));
       $data = $req->fetch();
      $_SESSION['users'] = $email;
      $_SESSION['id'] = $data['id'];
      $req->closeCursor();



      NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM */





       header('Location: profile-settings.php');

        } //end elseif rowcount == 0

      } // end if pass valid
        else { $valid = false;
        $erreuridd = _('Password must be at least 6 characters long.'); } // end if email not valid

        } //end if email valid

         else { $valid = false;
        $erreuridd = _('Invalid email.'); } // end if email not valid
    } //end if valid
} // end isset registration form

?>


<!DOCTYPE HTML>
<html class="full">

<head>
    <title>HopDriver - <?php echo _("Partners"); ?></title>


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

<body class="full">


    <div class="global-wrap">

        <div class="full-page">
            <div class="bg-holder full">
                <div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url(../img/aston-martin-1280x852.jpg);"></div>
                <div class="bg-holder-content full text-white">
                    <a class="logo-holder" href="http://www.imagidev.com/">
                       <img src="../img/logo-invert.png" alt="Home page" title="HopDriver" />
                    </a>
                    <div class="full-center">
                        <div class="container">
                            <div class="row row-wrap" data-gutter="60">
                                <div class="col-md-4">
                                    <div class="visible-lg">
                                        <h3 class="mb15"><?php echo _('Choose your driver'); ?></h3>
                                        <p><?php echo _('Compare and select your driver. The driver offers his own price and you pay him on-site.'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="mb15"><?php echo _("Login"); ?></h3>
                                    <?php if(isset($ok)){ ?>
                                      <div class="alert alert-success">
                                          <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                          </button>
                                          <p class="text-bigger"><strong><?php echo $ok; ?></strong></p>
                                      </div>
                                      <?php

                                      }

                                   elseif(isset($erreurid)){  ?>
                                    <div class="alert alert-danger">
                                      <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                      </button>
                                      <p class="text-bigger"><strong><?php echo $erreurid; ?></strong></p>
                                    </div> <?php } ?>


                                    <form action="login.php" name="login" method="post">
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
                                            <label><?php echo _('Email'); ?></label>
                                            <input class="form-control" placeholder="name@email.com" name="email" type="text" />
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
                                            <label><?php echo _('Password'); ?></label>
                                            <input class="form-control" type="password" name="pass" placeholder="********" />
                                        </div>
                                        <div class="gap gap-mini"></div>
                                        <div>
                                          <p><a class="btn btn-link" href="../newpassword.php" title="Did you forget your password?" target="_blank"><?php echo _('Forgot your password?'); ?></a></p>
                                        </div>
                                        <div class="gap gap-mini"></div>
                                        <input class="btn btn-primary" type="submit" name="login" value="<?php echo _('Sign in'); ?>" />
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="mb15"><?php echo _('Registration'); ?></h3>
                                    <?php if(isset($ok)){ ?>
                                      <div class="alert alert-success">
                                          <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                          </button>
                                          <p class="text-bigger"><strong><?php echo $ok; ?></strong></p>
                                      </div>
                                      <?php

                                      }

                                    elseif(isset($erreuridd)){  ?>
                                    <div class="alert alert-danger">
                                      <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                      </button>
                                      <p class="text-bigger"><strong><?php echo $erreuridd; ?></strong></p>
                                    </div> <?php } ?>

                                    <form action="login.php" name="register" method="post">
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
                                            <label><?php echo _('First Name'); ?></label>
                                            <input class="form-control" placeholder="<?php echo _('First Name'); ?>" name="first_name" type="text" />
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
                                            <label><?php echo _('Last Name'); ?></label>
                                            <input class="form-control" placeholder="<?php echo _('Last Name'); ?>" name="last_name" type="text" />
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
                                            <label><?php echo _('Email'); ?></label>
                                            <input class="form-control" placeholder="<?php echo _('name@email.com'); ?>" name="email" type="text" />
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
                                            <label><?php echo _('Password'); ?></label>
                                            <input class="form-control" type="password" name="pass" placeholder="<?php echo _('At least 6 characters'); ?>" />
                                        </div>
                                            <div class="gap gap-mini"></div>
                                        <input class="btn btn-primary" type="submit" name="register" value="<?php echo _('Submit form'); ?>" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="footer-links">


                                    <?php
                                    // $_SESSION['lang'] = 'fr_FR'; //à supprimer
                                    if($_SESSION['lang'] == 'fr_FR')
                                        { ?>
                                      <li><?php echo _('Language'); ?>: </a>
                                    </li>
                                          <li><a href="login.php?lang=en_US">English</a>
                                    </li>
                                    <?php
                                        }
                                    elseif($_SESSION['lang'] == 'en_US')
                                        { ?>
                                      <li><?php echo _('Language'); ?>: </a>
                                    </li>
                                          <li><a href="login.php?lang=fr_FR">Francais</a>
                                    </li>
                                       <?php  } else { ?>
                                      <li><?php echo _('Language'); ?>: </a>
                                    </li>
                                    <li><a href="login.php?lang=fr_FR">Francais</a>
                                    </li>

                                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>



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
        <script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
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
