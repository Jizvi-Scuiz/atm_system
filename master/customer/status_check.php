<?php session_start() ?>
<?php include 'function.php' ?>

<?php 
// echo "Hi";
$trac_id = $_POST['tr_id'];
sleep(12);
$tr_status = get_tr_status($trac_id);
if($tr_status == -1){
    echo "Transaction in Hold";
    echo '<br><a href="../customer/index.php">Home</a>';

}
elseif($tr_status == 0){
    echo '<h4 style="font-align: center">Transaction Declined</h4>';
    echo '<br><a href="../customer/index.php">Home</a>';
}
elseif($tr_status == 1){
    echo '<h4 style="font-align: center">Transaction Approved</h4>';
    echo '<br><a href="../customer/index.php">Home</a>';

}
?>