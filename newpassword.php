<?php
session_start();
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }
if(empty($_SESSION['lang'])){ $lang = 'en_US'; }

include 'config.php';

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


  if($_POST['loginclient'] == "Client")
  {


  $req = $bdd->prepare('SELECT * FROM clients WHERE email=:email');
  $req->execute(array(
    'email'=>$email
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = _('No account with that e-mail address exists.');
  }


  else
  {
    if($req->rowCount()>0)
    {
      $_SESSION['users'] = $email;
      $_SESSION['id'] = $data['id'];
      $first_name = $data['first_name'];
    }
  }

    $req->closeCursor();
    if($valid)
    {

                  function generate_password( $length = 8 ) {
                  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                  $password = substr( str_shuffle( $chars ), 0, $length );
                  return $password;
                  }

                  $forgotkey = generate_password();
                  $email = $_POST['email'];

                  $email_subject = _('Resetting your HopDriver password');
                  $type = "Client";
                  require_once('PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('newpassword_'.$lang.'.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%email%', $email, $mailmessage);
              $mailmessage = str_replace('%forgotkey%', $forgotkey, $mailmessage);
              $mailmessage = str_replace('%type%', $type, $mailmessage);


              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "780182038a"; // SMTP account username
              $mail->Password   = "0a10ae8dc1";        // SMTP account password
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

            $req = $bdd->prepare('INSERT INTO newpassword (email,forgotkey)
                    VALUES (:email,:forgotkey)');
                  $req->execute(array(
                    'email'=>$email,
                    'forgotkey'=>$forgotkey,

                  ));
                  $req->closeCursor();


            $ok = _("An e-mail has been sent to")." ".$email." ". _("with further instructions");

    }

  } //end if post client



    if($_POST['logindriver'] == "Driver")
  {


  $req = $bdd->prepare('SELECT * FROM chauffeurs WHERE email=:email');
  $req->execute(array(
    'email'=>$email
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
      $first_name = $data['first_name'];
    }
  }

    $req->closeCursor();
    if($valid)
    {

                  function generate_password( $length = 8 ) {
                  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                  $password = substr( str_shuffle( $chars ), 0, $length );
                  return $password;
                  }

                  $forgotkey = generate_password();
                  $email = $_POST['email'];

                  $email_subject = _('Resetting your HopDriver password');
                  $type = "Driver";

                  require_once('PHPMailer_5.2.4/class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP

            try {
              $mailmessage = file_get_contents('newpassword_'.$lang.'.html');
              $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
              $mailmessage = str_replace('%email%', $email, $mailmessage);
              $mailmessage = str_replace('%forgotkey%', $forgotkey, $mailmessage);
              $mailmessage = str_replace('%type%', $type, $mailmessage);

              $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
              $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
              $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "780189038a"; // SMTP account username
              $mail->Password   = "0a10aaffe8dc1";        // SMTP account password
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

            $req = $bdd->prepare('INSERT INTO newpassword (email,forgotkey)
                    VALUES (:email,:forgotkey)');
                  $req->execute(array(
                    'email'=>$email,
                    'forgotkey'=>$forgotkey,

                  ));
                  $req->closeCursor();


            $ok = _("An e-mail has been sent to")." ".$email." ". _("with further instructions");
    }

  } //end if post client


} // end valid
} // end post login



/*

    START NEW PASSWORD PROCESS ////////////////////////////////////////////////////////////////////////////////////////////


    */

if(isset($_GET['forgotkey']))
{
  $valid = true;
  extract($_POST);

  if($valid)
  {


  if($_GET['type'] == "Client")
  {
    $forgotkey = $_GET['forgotkey'];
    $type = $_GET['type'];

  $req = $bdd->prepare('SELECT * FROM newpassword WHERE forgotkey = :forgotkey');
  $req->execute(array(
    'forgotkey'=>$forgotkey
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = _('No account with that e-mail address exists.');
  }


  else
  {
    if($req->rowCount()>0)
    {
      $email = $data['email'];


    }
  }

    $req->closeCursor();
    if($valid)
    {


            $show_new_password_field = "All OK";
            $type = "Client";

    }

  } //end if post client


  if($_GET['type'] == "Driver")
  {
    $forgotkey = $_GET['forgotkey'];
    $type = $_GET['type'];


  $req = $bdd->prepare('SELECT * FROM newpassword WHERE forgotkey = :forgotkey');
  $req->execute(array(
    'forgotkey'=>$forgotkey
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = _('No account with that e-mail address exists.');
  }


  else
  {
    if($req->rowCount()>0)
    {
      $email = $data['email'];


    }
  }

    $req->closeCursor();
    if($valid)
    {


            $show_new_password_field = "All OK";
            $type = "Driver";

    }

  } //end if post driver


} // end valid
} // end post login






if(isset($_POST['changepass']))  {
  if(!empty($_POST['email']) && !empty($_POST['newpass']) && !empty($_POST['newpasstwo'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $erreurid = _('Please fill in all the fields.'); $show_new_password_field = "All OK";
    }


    if($valid)
    {

        $newpass = $_POST['newpass'];
        $newpasstwo = $_POST['newpasstwo'];
        $email = $_POST['email'];

        if( $newpass == $newpasstwo) {

         // check if password is valid
      if (preg_match("#^\S*(?=\S{6,30})(?=\S*[a-z])\S*$#", $newpass))
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


        $newpass = md5($newpass);

        if($_POST['type'] == "Driver") {

          $req = $bdd->prepare('UPDATE chauffeurs SET pass = :newpass
            WHERE email = :email');
          $req->execute(array(
            'newpass'=>$newpass,
            'email'=>$email,

          ));
          $req->closeCursor();

          $req = $bdd->prepare('DELETE FROM newpassword WHERE email = :email');
          $req->execute(array(
            'email'=>$email,

          ));
          $req->closeCursor();

           $ok = _("Password succesfully changed.");

       }

        if($_POST['type'] == "Client") {

          $req = $bdd->prepare('UPDATE clients SET pass = :newpass
            WHERE email = :email');
          $req->execute(array(
            'newpass'=>$newpass,
            'email'=>$email,

          ));
          $req->closeCursor();

          $req = $bdd->prepare('DELETE FROM newpassword WHERE email = :email');
          $req->execute(array(
            'email'=>$email,

          ));
          $req->closeCursor();

           $ok = _("Password succesfully changed.");

       }

     } // end if preg_match $newpass
     else { $erreurid = _('Password must be at least 6 characters long.'); $show_new_password_field = "All OK"; }

   }// end if newpass == newpasstwo
   else { $erreurid = _('The two new passwords does not match.'); $show_new_password_field = "All OK"; }

       } //end if valid
} //end if change password



?>


<!DOCTYPE HTML>
<html class="full">

<head>
    <title>HopDriver - <?php echo _("Forgot your password?"); ?></title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('airport transfers, private transfer, HopDriver, disposal services'); ?>" />
    <meta name="description" content="<?php echo _('HopDriver - private transfers and disposal services'); ?>">
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

<body class="full">


    <div class="global-wrap">

        <div class="full-page">
            <div class="bg-holder full">
                <div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url(img/aston-martin-1280x852.jpg);"></div>
                <div class="bg-holder-content full text-white">
                    <a class="logo-holder" href="http://imagidev.com/work/hopdriver/">
                       <img src="img/logo-invert.png" alt="Home page" title="HopDriver" />
                    </a>
                    <div class="full-center">
                        <div class="container">
                            <div class="row row-wrap" data-gutter="60">

                                <?php if(empty($show_new_password_field)) { ?>
                                <div class="col-md-4">
                                    <div class="visible-lg">
                                        <h3 class="mb15"><?php echo _('Forgot your password?'); ?></h3>
                                        <p><?php echo _('Enter your email address to reset your password. You may need to check your spam folder or unblock no-reply@imagidev.com.'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <?php if(isset($ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $erreurid; ?></p>
                                                        </div> <?php } ?>


                                    <form action="newpassword.php" name="login" method="post">
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
                                            <label><?php echo _('Email'); ?></label>
                                            <input class="form-control" placeholder="name@email.com" name="email" type="text" />
                                        </div>
                                        <div class="gap gap-mini"></div>
                                            <div class="radio-inline">
                                                <label><!-- <input class="i-radio" type="radio" name="myRadiolist" value="Client" checked /> -->
                                                    <input class="i-radio" type="radio" name="loginclient" value="Client" /><?php echo _('Client'); ?></label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input class="i-radio" type="radio" name="logindriver" value="Driver" /><?php echo _('Driver'); ?></label>
                                            </div>
                                        <div class="gap gap-mini"></div>
                                        <input class="btn btn-primary" type="submit" name="login" value="<?php echo _('Send'); ?>" />
                                    </form>
                                </div>
                                <?php } else { ?>
                                <div class="col-md-4">
                                    <div class="visible-lg">
                                        <h3 class="mb15"><?php echo _('Forgot your password?'); ?></h3>
                                        <p><?php echo _('Enter a new password for your account'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <?php if(isset($ok)){ ?>
                                                    <div class="alert alert-success">
                                                        <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                        </button>
                                                        <p class="text-small"><?php echo $ok; ?></p>
                                                    </div> <?php } ?>

                                                     <?php if(isset($erreurid)){ ?>
                                                        <div class="alert alert-danger">
                                                            <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">X</span>
                                                            </button>
                                                            <p class="text-small"><?php echo $erreurid; ?></p>
                                                        </div> <?php } ?>


                                    <form action="newpassword.php" method="post">
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label><?php echo _('New Password'); ?></label>
                                    <input class="form-control" type="password" name="newpass" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label><?php echo _('New Password Again'); ?></label>
                                    <input class="form-control" type="password" name="newpasstwo" />
                                    <input type="hidden" name="type" value="<?php echo $type; ?>" />
                                    <input type="hidden" name="email" value="<?php echo $email; ?>" />
                                        <div class="gap gap-mini"></div>
                                        <input class="btn btn-primary" type="submit" name="changepass" value="<?php echo _('Submit'); ?>" />
                                    </form>
                                </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <ul class="footer-links">


                                    <?php
                                    if($_SESSION['lang'] == 'fr_FR')
                                        { ?>
                                      <li><?php echo _('Language'); ?>: </a>
                                    </li>
                                          <li><a href="http://imagidev.com/work/hopdriver/partners/login.php?lang=en_US">English</a>
                                    </li>
                                    <?php
                                        }
                                    elseif($_SESSION['lang'] == 'en_US')
                                        { ?>
                                      <li><?php echo _('Language'); ?>: </a>
                                    </li>
                                          <li><a href="http://imagidev.com/work/hopdriver/partners/login.php?lang=fr_FR">Francais</a>
                                    </li>
                                       <?php  } else { ?>
                                      <li><?php echo _('Language'); ?>: </a>
                                    </li>
                                    <li><a href="http://imagidev.com/work/hopdriver/partners/login.php?lang=fr_FR">Francais</a>
                                    </li>

                                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>



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
        <script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
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
