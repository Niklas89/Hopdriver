<?php 
session_start();
 
// Suppression des variables de session et de la session
//$_SESSION = array();
//session_destroy();
 
// Suppression des cookies de connexion automatique
// setcookie('login', '');
// setcookie('pass_hache', '');

$_SESSION['id'] = $_GET['id'];
$_SESSION['users'] = $_GET['email'];

header('Location: ../driver/login.php');
exit();