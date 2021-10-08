<?php


try{
  $bdd = new PDO('mysql:host=localhost;dbname=my_database_name', 'username_login', 'mypassword') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES UTF8');
  }

  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }

$thispage = basename($_SERVER["SCRIPT_NAME"]);

?>
