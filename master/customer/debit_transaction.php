

<?php
    // echo "Default timezone: " . date_default_timezone_get();
    date_default_timezone_set('Asia/Kolkata');
    session_start();
    if(!isset($_SESSION['cus_id'])){
    header('location: ../customer/login.php');
    };
    include 'function.php';

    
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    // echo date("H:i:s");
    // die;
    $tr_time = date("H:i:s");
    $tr_date = date("y-m-d");
    $tr_acc_bal = fetch_acc_bal($_POST['acc_no']);
    $tr_ac_no = $_POST['acc_no'];
    $tr_card_no = $_POST['card_no'];
    $tr_card_exp_date = $_POST['exp_date'];
    $tr_type = $_POST['type'];
    $tr_status = $_POST['status'];
    $tr_amt = $_POST['amount'];
    $ac_no = $_POST['acc_no'];
    $transactionId = generateTransactionId();
    // die;

    $log_transac = "INSERT INTO transaction (TransactionID, Date, Time, CardNumber, AccountNumber, acc_bal, Type, Amount, Status)
            VALUES ('$transactionId', '$tr_date', '$tr_time', '$tr_card_no', '$tr_ac_no', '$tr_acc_bal', '$tr_type', '$tr_amt', '$tr_status')";
    $result = mysqli_query(db_con(), $log_transac);
    // echo '<bt>'.$result;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Status</title>   
    <link rel="stylesheet" href="../customer/style.css">
    
</head>
<body onload="check_st(<?php echo $transactionId; ?>)">
    <h4 style="margin: 10px; text-align: center">Waiting for admin response</h4>
    <h4 style="margin: 10px; text-align: center">Transaction ID: <?php echo $transactionId ;?></h4>
    <div class="container">
        <button class="btn-danger" id="stop" style="align-items: center;" onclick="end_tr(<?php echo $transactionId; ?>)"> Stop </button>
    </div>
   
    <p id="status" style="text-align: center" onmousemove="delete_()"> </p>
    
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script type="text/javascript">
	function check_st(tr_id) {
		$.ajax({
	        url: "status_check.php",
	        method: "POST",
	        datatype: "HTML",
	        data: {
                tr_id: tr_id
	        },
	        success: function(x){
                $("#status").html(x);
                $("#stop").hide(x);
	        }
	    });	
	}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
	function end_tr(tr_id) {
		$.ajax({
	        url: "stop_tr.php",
	        method: "POST",
	        datatype: "HTML",
	        data: {
                tr_id: tr_id
	        },
	        success: function(x){
                $("#status").html(x);
                
	        }
	    });	
	}
</script>
<script type="text/javascript">
	function delete_() {
		$.ajax({
	        success: function(x){
                $("#stop").hide(x);
	        }
	    });	
	}
</script>

<script>
$(document).hover(function(){
  $("#status").mousemove(function(){
    $(".btn-danger").hide();
  });
});
</script>