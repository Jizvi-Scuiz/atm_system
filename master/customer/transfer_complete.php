<?php
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};
include 'function.php';


?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // echo "Write and Execute Query";
    $select1 = $_POST['select1'];
    $select2 = $_POST['select2'];
    $amt = $_POST['amount'];
    $balance1 = get_balance($select1);
    $balance2 = get_balance($select2);
    $new1 = $balance1[0] - $amt;
    $new2 = $balance2[0] + $amt;
    $query1 = "UPDATE account SET Balance = $new1 WHERE AccountNumber = $select1";
    $result1 = mysqli_query(db_con(), $query1); 
    $query2 = "UPDATE account SET Balance = $new2 WHERE AccountNumber = $select2";
    $result2 = mysqli_query(db_con(), $query2);
    if($result1 == 1 && $result2 == 1){
        echo "Transfer Complete";
        echo "<div class='container'><a href='../customer/index.php'>Home</a></div>";
    } 

}

?>