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

require "localization.php"; 



include '../config.php';


    $sth = $bdd->prepare("SELECT * FROM chauffeurs WHERE id = :id_users");
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
        $phonetwo = $result->phonetwo;
        $languages = $result->languages;
        $vehicles = $result->vehicles;
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
        $phonetwo = $_POST['phonetwo'];
        $languages = $_POST['languages'];
        $vehicles = $_POST['vehicles'];
        $address = $_POST['address'];
        $postal_code = $_POST['postal_code']; 
        $country = $_POST['country'];
        
        if(!empty($_POST['company'])){ $company = $_POST['company']; } else { $company = $first_name." ".$last_name;  }
        



      $req = $bdd->prepare('UPDATE chauffeurs SET email = :email, city = :city, first_name = :first_name, last_name = :last_name,
       phone = :phone, phonetwo = :phonetwo, languages = :languages, vehicles = :vehicles, address = :address, postal_code = :postal_code, country = :country, company = :company 
        WHERE id = :id_users');
      $req->execute(array(
        'email'=>$email,
        'city'=>$city,
        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'phone'=>$phone,
        'phonetwo'=>$phonetwo,
        'languages'=>$languages,
        'vehicles'=>$vehicles,
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

      $req = $bdd->prepare('UPDATE chauffeurs SET pass = :newpass 
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






if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 500000)
        {
                // Testons si l'extension est autorisée
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
                //1. strrchr renvoie l'extension avec le point (« . »).
                //2. substr(chaine,1) ignore le premier caractère de chaine.
                //3. strtolower met l'extension en minuscules.
                $extension_upload = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );
                if (in_array($extension_upload, $extensions_valides))
                {
                        // On peut valider le fichier et le stocker définitivement

                   // $name = "photo/".$id_users.".".$extension_upload;
                    $name = "photo/{$id_users}.{$extension_upload}";
                     move_uploaded_file($_FILES['photo']['tmp_name'],$name);

                    $up_filesize = $_FILES['photo']['size'];
                    $up_title = "Profile Photo";
                    $up_description = $first_name." ".$last_name;
                    date_default_timezone_set('Europe/Madrid');
                    $up_filedate = date('Y-m-d H:i:s');


                    $req = $bdd->prepare('SELECT driverid FROM driver_photo WHERE driverid = :id_users');
                      $req->execute(array(
                        'id_users'=>$id_users
                      ));
                      $data = $req->fetch();
                      if($req->rowCount()>0)
                      {
                         $reqq = $bdd->prepare('UPDATE driver_photo SET up_filename = :name, up_filesize = :up_filesize, up_title = :up_title, up_description = :up_description,
                           up_filedate = :up_filedate, driverid = :id_users
                            WHERE driverid = :id_users');
                          $reqq->execute(array(
                            'name'=>$name,
                            'up_filesize'=>$up_filesize,
                            'up_title'=>$up_title,
                            'up_description'=>$up_description,
                            'up_filedate'=>$up_filedate,
                            'id_users'=>$id_users,
                            
                          ));
                          $reqq->closeCursor();

                        $ok = _("Photo succesfully updated.");

                      }
                      

                      elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                        {


                     $reqq = $bdd->prepare('INSERT INTO driver_photo (up_filename,up_filesize,up_title,up_description,up_filedate,driverid) VALUES (:name,:up_filesize,:up_title,:up_description,:up_filedate,:id_users)');
                      $reqq->execute(array(
                        'name'=>$name,
                        'up_filesize'=>$up_filesize,
                        'up_title'=>$up_title,
                        'up_description'=>$up_description,
                        'up_filedate'=>$up_filedate,
                        'id_users'=>$id_users,
                        
                      ));
                      $reqq->closeCursor();

                      $ok = _("Photo succesfully saved.");

                    }

                       
                }
                else { $erreurid = _('Wrong file format.'); }
        }
        else { $erreurid = _('File size to large.'); }
}







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
                                <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon"></i>
                                    <label><?php echo _('Second Phone (Optional)'); ?></label>
                                    <input class="form-control" value="<?php if (!empty($phonetwo)) { echo $phonetwo; } else { echo ""; } ?>" name="phonetwo" type="text" />
                                </div>
                                <div class="gap gap-small"></div>
                                <h4><?php echo _('Location'); ?></h4>
                                <div class="form-group">
                                    <label><?php echo _('Company / First & Last Name (no company)'); ?> <span style="color:red;">*</span></label>
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
                                <div class="gap gap-small"></div>
                                <h4><?php echo _('Professional Information'); ?></h4>
                                <div class="form-group form-group-icon-left"><i class="fa fa-comments input-icon"></i>
                                    <label><?php echo _('Spoken Languages'); ?> <span style="color:red;">*</span></label>
                                    
                                    <textarea rows="2" cols="50" name="languages" id="languages" class="form-control" type="textarea" /><?php if (!empty($languages)) { echo $languages; } else { echo ""; } ?></textarea>
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-align-left input-icon"></i>
                                    <label><?php echo _('Description'); ?> <span style="color:red;">*</span></label>
                                    
                                    <textarea rows="5" cols="50" name="vehicles" id="vehicles" class="form-control" type="textarea" /><?php if (!empty($vehicles)) { echo $vehicles; } else { echo ""; } ?></textarea>
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
                                <input class="btn btn-primary" type="submit" name="changepass" value="Change Password" />
                            </form>
                                <div class="gap gap-small"></div>
                            <h4><?php echo _('Profile Photo'); ?></h4>
                            <form method="post" action="profile-settings.php" enctype="multipart/form-data" accept-charset="utf-8">
                                 <label for="photo">(JPG, PNG, GIF | max. 500 Ko) :</label><br />
                                 <input class="btn btn-primary"  type="file" name="photo" id="photo" /><br />
                                 <input class="btn btn-primary"  type="submit" value="<?php echo _('Upload Photo'); ?>" />
                            </form>
                                <div class="gap gap-small"></div>
                                <div class="gap gap-small"></div>

                                <div class="gap gap-small"></div>
                                <div class="gap gap-small"></div>

                                
                            <div class="alert alert-warning">
                                <h4><span style="color:red;">*</span></h4>
                                <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                </button>
                                <p class="text-small"><?php echo _('These fields will appear in the search results'); ?></p>
                            </div>

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


