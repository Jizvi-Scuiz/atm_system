<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('location: ../admin/admin_login.php');
}
include '../db_connection.php';
include 'function.php';
if(isset($_POST['acc_no'])){
    $id = $_POST['acc_no'];
    $activate = activate_account($id);
    if($activate){
        echo "Account Activated";
    }

}
if(isset($_POST['submit'])){
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    // die;
    $tr_id = $_POST['tr_id'];
    $tr_ac = $_POST['action'];
    $tr_acc_no = $_POST['ac_no'];
    $acc_bal = $_POST['acc_bal'];
    $amt = $_POST['tr_amt'];
    if($_POST['tr_type'] == 'Debit'){
        $updated_bal = $acc_bal - $amt;
        if($tr_ac == 'ver'){
            $query = "UPDATE transaction SET Status = 1 WHERE TransactionID = $tr_id";
            $result = mysqli_query(db_con(), $query);
            $query1 = "UPDATE account SET Balance = $updated_bal WHERE AccountNumber = $tr_acc_no";
            $result1 = mysqli_query(db_con(), $query1);
            $query2 = "UPDATE transaction SET acc_bal = $updated_bal WHERE AccountNumber = $tr_acc_no AND TransactionID != $tr_id AND Status = '-1'";
            $result2 = mysqli_query(db_con(), $query2);
            if($result == 1 && $result1 == 1 && $result2 == 1){
                header('location: ../admin/index.php');
            }
            else{
                echo "Query Run Error";
            }
        }
        elseif($tr_ac == 'rej'){
            $query = "UPDATE transaction SET Status = 0 WHERE TransactionID = $tr_id";
            $result = mysqli_query(db_con(), $query);
            echo $result;
            if($result == 1){
                header('location: ../admin/index.php');
            }
        }

    }
    elseif($_POST['tr_type'] == 'Credit'){
        $updated_bal = $acc_bal + $amt;
        if($tr_ac == 'ver'){
            $query = "UPDATE transaction SET Status = 1 WHERE TransactionID = $tr_id";
            $result = mysqli_query(db_con(), $query);
            $query1 = "UPDATE account SET Balance = $updated_bal WHERE AccountNumber = $tr_acc_no";
            $result1 = mysqli_query(db_con(), $query1);
            $query2 = "UPDATE transaction SET acc_bal = $updated_bal WHERE AccountNumber = $tr_acc_no AND TransactionID != $tr_id AND Status = '-1'";
            $result2 = mysqli_query(db_con(), $query2);
            if($result == 1 && $result1 == 1 && $result2 == 1){
                header('location: ../admin/index.php');
            }
            else{
                echo "Query Run Error";
            }
        }
        elseif($tr_ac == 'rej'){
            $query = "UPDATE transaction SET Status = 0 WHERE TransactionID = $tr_id";
            $result = mysqli_query(db_con(), $query);
            echo $result;
            if($result == 1){
                header('location: ../admin/index.php');
            }
        }
    }
    // echo $tr_ac;


}
