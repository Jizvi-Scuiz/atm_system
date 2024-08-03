<?php 
session_start();
include 'function.php';
?>

<?php 
if(isset($_POST['card_no'])){
    $_SESSION['card_no'] = $_POST['card_no'];
}
