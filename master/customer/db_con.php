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
