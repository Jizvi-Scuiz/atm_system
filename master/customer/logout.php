<?php
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};

include 'db_connection.php';

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location: ../customer/login.php');
}

?>