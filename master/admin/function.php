<?php

function db_con(){
    $dbhost = "localhost";
    $db_name = "atm_system";
    $dbuser = "root";
    $dbpass = "";
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db_name);
    if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit;
    }
    else
        return $conn;
}

$con = db_con();
function fetch_new_acc(){
    $query = mysqli_query(db_con(), "SELECT * FROM account WHERE active_status = 0");
    $data = mysqli_fetch_all($query);
    // print_r($data);
	return $data;
}

function activate_account($id){
    $query = "UPDATE account SET active_status = 1 WHERE CustomerId = $id";
    $result = mysqli_query(db_con(), $query);
    return $result;
}

function get_pending_transacs(){
    $query = "SELECT * FROM transaction WHERE Status = -'1'";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    // die;
    return $result_1;
}