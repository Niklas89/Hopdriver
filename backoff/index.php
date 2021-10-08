<?php 
session_start();
if(!empty($_SESSION['id']))
{
  header('Location: transfers.php');
}
else {
  header('Location: login.php');
}
  ?>