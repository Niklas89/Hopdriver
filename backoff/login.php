<?php
session_start();
if(!empty($_SESSION['id']))
{
  header('Location: transfers.php');
}


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

  $req = $bdd->prepare('SELECT * FROM admins WHERE email=:email AND pass=:pass');
  $req->execute(array(
    'email'=>$email,
    'pass'=>$pass
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = 'Please fill in the form correctly.';
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
      header('Location: transfers.php');
    }
  


} // end valid
} // end post login





?>


<!DOCTYPE HTML>
<html class="full">

<head>
    <title>HopDriver - Admin</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="airport transfers, private transfer, HopDriver, disposal services" />
    <meta name="description" content="HopDriver - private transfers and disposal services">
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
                    <a class="logo-holder" href="http://imagidev.com/work/hopdriver/">
                       <img src="../img/logo-invert.png" alt="Home page" title="HopDriver" />
                    </a>
                    <div class="full-center">
                        <div class="container">
                            <div class="row row-wrap" data-gutter="60">
                                <div class="col-md-4">
                                    <div class="visible-lg">
                                        <h3 class="mb15">Administration</h3>
                                        <p>Area to manage clients, drivers and bookings.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="mb15">Login</h3>
                                    <?php if(isset($ok)){ echo '<p id="ok">'.$ok.'</p>';} 
                                    elseif(isset($erreurid)){  echo '<p id="erreurid">'.$erreurid.'</p>'; } ?>
                                    <form action="login.php" method="post">
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
                                            <label>Email</label>
                                            <input class="form-control" placeholder="name@email.com" name="email" type="text" />
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
                                            <label>Password</label>
                                            <input class="form-control" type="password" name="pass" placeholder="********" />
                                        </div>
                                        <div class="gap gap-mini"></div>
                                        <input class="btn btn-primary" type="submit" name="login" value="Sign in" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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


