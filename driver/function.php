<?php

function getDriverStart() {


	$id_users = $_SESSION['id'];
    $email =  $_SESSION['users'];

    $bdd = getBdd();
	$thispage = basename($_SERVER["SCRIPT_NAME"]);

	 $req = $bdd->prepare('SELECT id,email FROM chauffeurs WHERE id=:id_users AND email = :email');
  $req->execute(array(
    'id_users'=>$id_users,
    'email'=>$email
  ));
  $data = $req->fetch();

  if($req->rowCount()>0)
    {
      header('Location: profile.php');
    }
    else {

      header('Location: ../client/login.php');
    }

    $req->closeCursor();

}



function getBdd() {
	try{
	  $bdd = new PDO('mysql:host=localhost;dbname=my_database', 'my_username', 'my_password') or die(print_r($bdd->errorInfo()));
	  $bdd->exec('SET NAMES UTF8');
	  }

	  catch(Exeption $e){
	  die('Erreur:'.$e->getMessage());
	  }
	 return $bdd;

}
