<?php
session_start();
if(!isset($_SESSION['cus_id'])){
header('location: ../customer/login.php');
};

include 'function.php';

?>

<?php $id = $_POST['tr_id'];
$sql = "UPDATE transaction SET status = 0 WHERE TransactionID = $id";
$result = mysqli_query(db_con(), $sql);
if ($result == 1){
    echo "Transaction aborted..";
}

?>