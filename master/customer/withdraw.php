<?php 
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};
include 'function.php';
$pin = get_card_pin($_POST['card_no']); //entire card details
// echo '<pre>';
// var_dump($pin);
// echo '</pre>';
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
$accounts = get_accounts_linked($_POST['card_no']);
if($pin[2] != $_POST['pin_entered'] || $pin[3] != $_POST['cvv'] || $pin[4] != $_POST['card_name_entered'] || $pin[5] != $_POST['exp_date'] || $pin[6] == 0){
    header('location: ../customer/index.php?msg=Invalid Card');
}
else{
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Withdrawal</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- <div class="form-section"> -->
        <form action="debit_transaction.php" method="post" style="margin-top:  15px; width: 50%; margin-left: auto; margin-right:auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <label>Select Account:</label>
            <select name="acc_no" required>
                <option value="">------Select Account------</option>
                <?php
                    foreach ($accounts as $value => $label) {
                        echo "<option value=\"$label[0]\">$label[0]</option>";
                    }
                    ?>
                </select>
            <br>
            <input type="hidden" name="card_no" value="<?php echo $pin[1]; ?>">
            <input type="hidden" name="exp_date" value="<?php echo $pin[5]; ?>">
            <input type="hidden" name="type" value="Debit">
            <input type="hidden" name="status" value="-1">
            <input type="hidden" name="amount" value="<?php echo ($_POST['qty'] * 20) ;?>">
            <input type="submit" name="submit" value="Withdraw">
        </form>
        <!-- </div> -->
    </body>
    </html>

<?php 
} ?>