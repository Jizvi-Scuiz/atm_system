<?php
session_start();
if(!isset($_SESSION['admin_id'])){
   header('location: ../admin/admin_login.php');
}
include '../db_connection.php';

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location: ../admin/admin_login.php');   
}

?>