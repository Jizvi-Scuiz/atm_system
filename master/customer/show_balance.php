<?php
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};

include 'function.php';
$acc_balance = get_balance($_POST['acc_no']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Balance</title>
    <link rel="stylesheet" href="../customer/style.css">
</head>
<body>
    <label for="" style="text-align: center">Account Number: <?php echo $_POST['acc_no']; ?> </label>
    <label for="" style="text-align: center">Balance: <?php echo $acc_balance[0]; ?> </label>
</body>
</html>