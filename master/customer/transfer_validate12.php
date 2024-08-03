<?php
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};
include 'function.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $select1 = $_POST['select1'];
    $select2 = $_POST['select2'];
    $amt = $_POST['amount'].'<br>';
    // Process the values here
    // For example, you could concatenate them or perform some other logic
    if($select1 != "" AND $select2 != ""){
        if($select1 == $select2){
            echo "Please select different Accounts";
        }
        else{
            $acc_bal = get_balance($select1);
            
            echo "Available balance: ".$acc_bal[0];
            if($acc_bal[0] > $_POST['amount']){
                echo "<div class='container'>Balance available</div>";
                $counter = 1;
            }
            else{
                echo "<div class='container'>Insufficient Balance</div>";
                $counter = 0;
            }
            echo "<br><p id='confirm'> </p>";
            // echo '<button >Confirm transfer</button>'
            //get transfer from account balance
            //update balance if balance is available in from account
        }

    }
    else{
        echo "Select Accounts";
    }

    // Return the result
    // echo $result;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Validate</title>
    <link rel="stylesheet" href="../customer/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <p id='transfer_com'>  </p>
    <?php if($counter == 1){
    ?>
        <div class='button-container'> 
            <button class='btn-primary' id='proceed_transfer'> Proceed Transfer </button> 
        </div>

    <?php } ?>
</body>
</html>


<script>
$(document).ready(function(){
    $("#proceed_transfer").click(function(){
        
        $.ajax({
            url: 'transfer_complete.php',
            type: 'POST',
            data: {
                select1: <?php echo $select1; ?>,
                select2: <?php echo $select2;?>,
                amount: <?php echo $amt; ?>
            },
            success: function(response){
                $("#transfer_com").html(response);
            }
        });
    });
});
</script>





