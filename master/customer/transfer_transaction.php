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
$amt = $_POST['qty'];
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
    <title>Transfer</title>
    <link rel="stylesheet" href="../customer/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <div class="container" style="margin-top: 10px;" >
        <table class="table">
            <tr>
                <td>
                    <label>Transfer From Account:</label>
                    <select name="from_acc_no" id="from_acc_no" required>
                        <option value="">------Select Account------</option>
                        <?php
                            foreach ($accounts as $value => $label) {
                                echo "<option value=\"$label[0]\">$label[0]</option>";
                            }
                            ?>
                    </select>
                </td>
                <td>
                    <label>Transfer to Account:</label>
                    <select name="to_acc_no" id="to_acc_no" required>
                        <option value="">------Select Account------</option>
                        <?php
                            foreach ($accounts as $value => $label) {
                                echo "<option value=\"$label[0]\">$label[0]</option>";
                            }
                            ?>
                    </select>
                </td>
                
            </tr>
        </table>
        
    </div>
    <div class="container" style="margin-top: 10px;">
        <button class="btn-primary" id="transfer">Transfer</button>
    </div>
    
    <div class="container" style="margin-top: 10px;">
        <p id="result">   </p>
    </div>
    
</body>
</html>

<?php }?>

<script>
$(document).ready(function(){
    $("#transfer").click(function(){
        var select1Value = $("#from_acc_no").val();
        var select2Value = $("#to_acc_no").val();

        $.ajax({
            url: 'transfer_validate.php',
            type: 'POST',
            data: {
                select1: select1Value,
                select2: select2Value,
                amount: <?php echo $amt; ?>
            },
            success: function(response){
                $("#result").html(response);
            }
        });
    });
});
</script>