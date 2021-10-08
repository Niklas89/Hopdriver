<?php
session_start();
$id_users = $_SESSION['id'];

if(empty($_SESSION['id']))
{
  header('Location: login.php');
  exit();
}

  include '../config.php';


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Voklee - Transfer Details</title>


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

        <!-- Including jQuery and rating plugin -->
        <script type="text/javascript" src="../rating/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../rating/js/jquery.5stars.min.js"></script>
        
        <!-- Starting rating plugin -->
        <script type="text/javascript">
            $(document).ready(function(){ 

    //start plugin
                $(".stars").rating({                       
                    php : '../rating/admin/php/manager.php',    //path to manager.php file relative to HTML document. Not required in Display-only and Database-free modes.
                    skin    : '../rating/skins/sticker_white.png | ../rating/skins/sticker_blue.png',      //path to skin file relative to HTML document
                    displaymode    : false,      //if true - no database reqired, values will be taken from html

                    textminvotes    : '%r <?php echo _("votes required"); ?>',      //if number of votes is less then minvotes this text will be shown
                    textmain          : "<span style='color:red;'>%ms</span> / %maxs <span class='code'>(%v <?php echo _('votes'); ?>)</span>",      //main text, shown then stats are loaded
                    textthanks:'<?php echo _("Thank you for voting"); ?>',
                    texthover: '<?php echo _("very bad"); ?>|<?php echo _("bad"); ?>|<?php echo _("average"); ?>|<?php echo _("good"); ?>|<?php echo _("perfect"); ?>',  //text shown on mouse move in format 'txt1|txt2|txt3|...|txtN'. Which part of this text will be shown depends on pointed value
                    debug             : false,      //if true - debug mode will be enabled

                    onclick            : onclick      //triggers then user voted
                });                 

      });
      
            function onclick(value){
                //your code here
                //alert('on click: '+value+'%');
            }
            
               
        </script>  


</head>

<body>


    <div class="global-wrap">
        
        <?php include '../header_partners.php'; ?>

        <div class="container">
            <h1 class="page-title">Our Drivers</h1>
        </div>




        <div class="container">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <div class="col-md-9">
                    <div class="checkbox">
                        <label>
                            <!--<input class="i-check" type="checkbox" />-->Driver details are indicated below:</label>
                    </div>
                    <table class="table table-bordered table-striped table-booking-history">
                        <tbody>
                             <?php 


                     

      



                               $resultats=$bdd->query('SELECT * FROM chauffeurs WHERE id=\'' . $_GET['id'] . '\' ');
                      $resultats->setFetchMode(PDO::FETCH_OBJ);
                      while( $resultat = $resultats->fetch() )
                      {

                                ?>
                                         
                                        <tr><td class="booking-history-title">Company</td><td><?php echo $resultat->company; ?></td></tr> 
                                        <tr><td class="booking-history-title">Email</td><td><?php echo $resultat->email; ?></td></tr>
                                        <tr><td class="booking-history-title">Name</td><td><?php echo $resultat->first_name; ?> <?php echo $resultat->last_name; ?></td></tr>
                                        <tr><td class="booking-history-title">City, Country</td><td><?php echo $resultat->city; ?>, <?php echo $resultat->country; ?></td></tr>
                                        <tr><td class="booking-history-title">Address</td><td><?php echo $resultat->address; ?> <?php echo $resultat->postal_code; ?></td></tr>
                                        <tr><td class="booking-history-title">Phone</td><td><?php echo $resultat->phone; ?></td></tr> 
                                        <tr><td class="booking-history-title">Phone 2</td><td><?php echo $resultat->phonetwo; ?></td></tr>
                                        <tr><td class="booking-history-title">Description</td><td><?php echo nl2br($resultat->vehicles); ?></td></tr> 
                                        <tr><td class="booking-history-title">Languages</td><td><?php echo nl2br($resultat->languages); ?></td></tr>
                                        <tr><td class="booking-history-title">Registered date</td><td><?php echo $resultat->date_inscription; ?></td></tr>
                                        <tr><td><a class="btn btn-info btn-sm" href="connect-driver.php?id=<?php echo $resultat->id; ?>&email=<?php echo $resultat->email; ?>" title="Connect">Connect</a></td></tr>
                                         click to vote: <div class="stars" data-id="<?php echo $resultat->id; ?>" data-title="<?php echo $resultat->company; ?>"></div>
                                         


                                          

                                      <?php 
                                   
                              }
                              $resultats->closeCursor();

                             $driver_id = $_GET['id'];

                            $sth = $bdd->prepare("SELECT * FROM rating_summary WHERE id = :driver_id");
                            $sth->execute(array(':driver_id' => $driver_id));
                            $result = $sth->fetch(PDO::FETCH_OBJ);
                            $sth->closeCursor();
                            $votes = $result->votes;
                            $value = $result->mean; 
                            ?> 
                              display only: <div class="stars" data-value="<?php echo $value; ?>" data-votes="<?php echo $votes; ?>" data-displaymode="true"></div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="gap"></div>



        <?php include '../footer.php'; ?>

       
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


