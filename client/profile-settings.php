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


    $sth = $bdd->prepare("SELECT * FROM clients WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $pass = $result->pass;
        $email = $result->email;
        $date_inscription = $result->date_inscription;
        $city = $result->city;
        $first_name = $result->first_name;
        $last_name = $result->last_name;
        $phone = $result->phone;
        $address = $result->address;
        $postal_code = $result->postal_code; 
        $country = $result->country;
        $company = $result->company;



if(isset($_POST['changesettings']))  {
  if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $erreurid = _('Please fill in all the fields.');
    }
  
  
    if($valid)
    {


        $email = $_POST['email'];
        $city = $_POST['city'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $postal_code = $_POST['postal_code']; 
        $country = $_POST['country'];
        $company = $_POST['company'];
        



      $req = $bdd->prepare('UPDATE clients SET email = :email, city = :city, first_name = :first_name, last_name = :last_name,
       phone = :phone, address = :address, postal_code = :postal_code, country = :country, company = :company 
        WHERE id = :id_users');
      $req->execute(array(
        'email'=>$email,
        'city'=>$city,
        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'phone'=>$phone,
        'address'=>$address,
        'postal_code'=>$postal_code,
        'country'=>$country,
        'company'=>$company,
        'id_users'=>$id_users,
        
      ));
      $req->closeCursor();

       $ok = _("Settings succesfully changed.");


       } //end if valid
} // end if isset change settings




if(isset($_POST['changepass']))  {
  if(!empty($_POST['passform']) && !empty($_POST['newpass']) && !empty($_POST['newpasstwo'])
      ) {
    extract($_POST);
    $valid = true;
    } else {
     $valid = false;
    $erreurid = _('Please fill in all the fields.');
    }
  
  
    if($valid)
    {
        
        if( $pass == md5($_POST['passform'])) {

        $newpass = $_POST['newpass'];
        $newpasstwo = $_POST['newpasstwo'];

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

      $req = $bdd->prepare('UPDATE clients SET pass = :newpass 
        WHERE id = :id_users');
      $req->execute(array(
        'newpass'=>$newpass,
        'id_users'=>$id_users,
        
      ));
      $req->closeCursor();

       $ok = _("Settings succesfully changed.");

     } // end if preg_match $newpass  
     else { $erreurid = _('Password must be at least 6 characters long.'); }

   }// end if newpass == newpasstwo
   else { $erreurid = _('The two new passwords does not match.'); }
} // end if bdd pass == posted pass
else { $erreurid = _('Please type the correct current password.'); }

       } //end if valid
} //end if change password


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - <?php echo _('Account Settings'); ?></title>


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
            <h1 class="page-title"><?php echo _('Account Settings'); ?></h1>
        </div>




        <div class="container">
            <div class="row">
                <?php $driverfirst_name = $first_name; $driverlast_name = $last_name; ?>
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <form action="profile-settings.php" method="post">
                                <h4><?php echo _('Personal Infomation'); ?></h4>

                        <?php if(isset($ok)){ echo '<p id="ok">'.$ok.'</p>';} 
                    elseif(isset($erreurid)){ ?>
                    
                      <?php echo '<p id="erreurid">'.$erreurid.'</p>'; } ?>
                                <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                    <label><?php echo _('First Name'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($first_name)) { echo $first_name; } else { echo ""; } ?>" name="first_name" type="text" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                    <label><?php echo _('Last Name'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($last_name)) { echo $last_name; } else { echo ""; } ?>" name="last_name" type="text" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
                                    <label><?php echo _('E-mail'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($email)) { echo $email; } else { echo ""; } ?>" name="email" type="text" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon"></i>
                                    <label><?php echo _('Phone Number'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($phone)) { echo $phone; } else { echo ""; } ?>" name="phone" type="text" />
                                </div>
                                <div class="gap gap-small"></div>
                                <h4><?php echo _('Location'); ?></h4>
                                <div class="form-group">
                                    <label><?php echo _('Company'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($company)) { echo $company; } else { echo ""; } ?>" name="company" type="text" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo _('Street Address'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($address)) { echo $address; } else { echo ""; } ?>" name="address" type="text" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo _('City'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($city)) { echo $city; } else { echo ""; } ?>" name="city" type="text" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo _('ZIP code/Postal code'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($postal_code)) { echo $postal_code; } else { echo ""; } ?>" name="postal_code" type="text" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo _('Country'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($country)) { echo $country; } else { echo ""; } ?>" name="country" type="text" />
                                </div>

                                <hr>
                                <input type="submit" class="btn btn-primary" name="changesettings" value="<?php echo _('Save Changes'); ?>">
                            </form>
                        </div>
                        <div class="col-md-4 col-md-offset-1">
                            <h4><?php echo _('Change Password'); ?></h4>
                            <form action="profile-settings.php" method="post">
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label><?php echo _('Current Password'); ?></label>
                                    <input class="form-control" type="password" name="passform" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label><?php echo _('New Password'); ?></label>
                                    <input class="form-control" type="password" name="newpass" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label><?php echo _('New Password Again'); ?></label>
                                    <input class="form-control" type="password" name="newpasstwo" />
                                </div>
                                <hr />
                                <input class="btn btn-primary" type="submit" name="changepass" value="<?php echo _('Change Password'); ?>" />
                            </form>
                        </div>
                    </div>

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


