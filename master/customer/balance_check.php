<?php
include 'function.php';
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};
?>

<?php 
if(!isset($_POST['card_no'])){
    header('location: ../customer/index.php');
}
$pin = get_card_pin($_POST['card_no']);
// echo '<pre>';
// var_dump($pin);
// echo '</pre>';
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;
$accounts = get_accounts_linked($_POST['card_no']);
if($pin[2] != $_POST['pin_entered'] || $pin[3] != $_POST['cvv'] || $pin[4] != $_POST['card_name_entered'] || $pin[5] != $_POST['exp_date'] || $pin[6] == 0){
    header('location: ../customer/index.php?msg=Invalid Card');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Account</title>
    <link rel="stylesheet" href="../customer/style.css">
</head>
<body>
        <div class="drop_down">

            <form action="show_balance.php" method="post" style="margin-top:  15px; width: 50%; margin-left: auto; margin-right:auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <label>Select Account:</label>
            <select name="acc_no" required>
                <option value="">------Select Account------</option>
                <?php
                    foreach ($accounts as $value => $label) {
                        echo "<option value=\"$label[0]\">$label[0]</option>";
                    }
                    ?>
                </select>
                <button type="submit" style="background-color: green; 
                                                color: white; 
                                                border: none; 
                                                padding: 5px 10px; 
                                                font-size: 16px; 
                                                cursor: pointer;
                                                margin-top: 5px;
                                                border-radius: 5px;
                                                font-weight: bold;"
                                                
                                                name="submit">
                                                Check Balance
                </button>

            </form>
        </div>
</body>
</html>