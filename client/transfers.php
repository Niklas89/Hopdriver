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

$sth = $bdd->prepare("SELECT first_name, last_name, email FROM clients WHERE id = :id_users");
        $sth->execute(array(':id_users' => $id_users));
        $result = $sth->fetch(PDO::FETCH_OBJ);
        $sth->closeCursor();
        $driveremail = $result->email;
        $driverfirst_name = $result->first_name;
        $driverlast_name = $result->last_name;





///////////////////////////////////// PAGINATION ////////////////////////////////////////

$messagesParPage=10; //Nous allons afficher 5 messages par page.
 
//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM transfers_booking WHERE clientid='.$id_users.'');
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
    <title><?php echo _('New Transfers'); ?></title>


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
                                <th><?php echo _('Price'); ?></th>
                                <th><?php echo _('Confirmed'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 


                  $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
                   
                  
                      

      


                              // La requête sql pour récupérer les messages de la page actuelle.
                              $retour_messages=$bdd->query('SELECT * FROM transfers_booking WHERE clientid='.$id_users.' ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
                              $retour_messages->setFetchMode(PDO::FETCH_OBJ);
                              while( $resultat = $retour_messages->fetch() )
                              { 


                                ?>

                                         
                                        <tr>
                                            <td class="booking-history-title"><?php echo $resultat->service; ?>
                                            </td>
                                            <td><?php echo $resultat->origin; ?></td>
                                            <td><?php echo $resultat->destination; ?></td>
                                            <td><?php echo $resultat->pickupdate; ?></td>
                                            <td><?php echo $resultat->pickuptime; ?></td>
                                            <td><a class="btn btn-info btn-sm" href="transferdetails.php?id=<?php echo $resultat->id; ?>" title="<?php echo _('View details'); ?>"><?php echo _('View'); ?></a></td>
                                            <?php 
                                                if($resultat->accepted == 0) {
                                            ?>
                                                  <td><?php echo $resultat->price; ?>€</td>
                                                  <td class="text-center"><i class="fa fa-circle-o"></i>
                                                  </td> 
                                                  <?php } else { ?>
                                                  <td><?php echo $resultat->price; ?>€</td>
                                                  <td class="text-center"><i class="fa fa-check"></i>
                                                  </td>
                                                  <?php } 
                                                ?>
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
                              // voir si on peut rajouter booking history apres un certain nb de pages ou faire truc fluide avec des "..." //////
                              // voir si le ORDER BY id marche bien ////////
                             
                              
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


