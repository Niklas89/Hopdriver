<?php 
session_start();
if(!empty($_SESSION['id']))
{

	$id_users = $_SESSION['id'];
    $email =  $_SESSION['users'];


	include '../config.php';


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
else {
  header('Location: login.php');
}
  ?>