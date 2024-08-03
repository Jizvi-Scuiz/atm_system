<?php 
include 'db_con.php';
?>

<?php 

function get_account_No($id){
    $query = mysqli_query(db_con(), "SELECT AccountNumber FROM account WHERE CustomerId = $id");
    $data = mysqli_fetch_all($query);
    // print_r($data);
	return $data[0][0];
}
?>

<?php 
function check_status($id){
    $query = mysqli_query(db_con(), "SELECT active_status FROM account WHERE CustomerId = $id");
    $data = mysqli_fetch_all($query);
    // print_r($data[0][0]);
	return $data[0][0];
}
?>

<?php 
function add_card($card_number,$card_name,$cvv,$pin,$exp_date,$account_number){
    // echo $expiry_date;
    $query = "SELECT * FROM atm_card WHERE card_no = $card_number AND pin = $pin AND cvv = $cvv ";
    $data = db_con()->query($query);
    if($data->num_rows > 0 ){
        while($row = $data->fetch_object()){
            // echo $exp_date.'<br>';
            // echo $row->expiry_date;
            if($card_name == strtoupper($row->card_name) AND $exp_date = $row->expiry_date){
                // echo $card_number;
                // echo "name matched and exp matched";
                $sql = "INSERT INTO cardaccount (CardNumber, acc_no) VALUES ('$card_number', $account_number)";
                $result = mysqli_query(db_con(), $sql);
                return $result;
            }
        }
    }

}

?>

<?php

$conn = db_con();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateATMCardNumber($conn) {
    // Prefix for the card, can be changed to match specific card type rules
    $prefix = '4'; // Example prefix for Visa cards

    do {
        // Generate the first 15 digits randomly
        $cardNumber = $prefix;
        for ($i = 0; $i < 14; $i++) {
            $cardNumber .= mt_rand(0, 9);
        }

        // Calculate the Luhn check digit
        $checkDigit = calculateLuhnCheckDigit($cardNumber);

        // Append the check digit to the card number
        $cardNumber .= $checkDigit;

        // Check if the card number already exists in the database
        $exists = checkCardNumberExists($conn, $cardNumber);
    } while ($exists);

    return $cardNumber;
}

function calculateLuhnCheckDigit($number) {
    $sum = 0;
    $length = strlen($number);

    // Perform the Luhn algorithm on the number
    for ($i = 0; $i < $length; $i++) {
        $digit = intval($number[$length - $i - 1]);

        if ($i % 2 == 0) {
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }

        $sum += $digit;
    }

    // Calculate the check digit
    $checkDigit = (10 - ($sum % 10)) % 10;

    return $checkDigit;
}

function checkCardNumberExists($conn, $cardNumber) {
    $sql = "SELECT card_no FROM atm_card WHERE card_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cardNumber);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    
    return $exists;
}

function generateRandomPin() {
    return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
}

function generateRandomCvv() {
    return str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
}

// Generate a new ATM card number


// Close connection
// $conn->close();

?>

<?php
function get_id($account_number){
    $query = "SELECT CustomerId from account WHERE AccountNumber = $account_number";
    $data = mysqli_query(db_con(), $query);
    // print_r($data);
    $result = mysqli_fetch_all($data);
    return $result[0][0];
}

?>

<?php
function get_acc_det($get_cus_id){
    $query = "SELECT Name from customer WHERE CustomerID = $get_cus_id";
    $data = mysqli_query(db_con(), $query);
    // print_r($data);
    $result = mysqli_fetch_all($data);
    return $result[0][0];
}
?>

<?php 
function add_new_card($newCardNumber, $get_name, $randomPin, $randomCvv, $exp_date){
    $query = "INSERT INTO atm_card (card_no, card_name, pin, cvv, expiry_date, active_status)
        VALUES ('$newCardNumber', '$get_name', '$randomPin', '$randomCvv', '$exp_date', '1')";
    $result = mysqli_query(db_con(), $query);
    return $result;
    
}
function get_cards_in_acc($fetch_card_no){
    // echo $fetch_card_no;
    $query = "SELECT CardNumber FROM cardaccount WHERE acc_no = $fetch_card_no";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1;
}

function get_accounts_linked($fetch_card_no){
    $query = "SELECT acc_no FROM cardaccount WHERE CardNumber = $fetch_card_no";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1;
}

?>

<?php 
function get_balance($acc_no){
    $query = "SELECT Balance FROM account WHERE AccountNumber = $acc_no";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1[0];
}

function get_card_pin($card_number){
    $query = "SELECT * FROM atm_card WHERE card_no = $card_number";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1[0];    
}

function fetch_acc_bal($ac_no){
    $query = "SELECT Balance FROM account WHERE AccountNumber = $ac_no";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1[0][0];

}

function get_tr_id($tr_ac_no,$tr_card_no,$tr_date,$tr_time){
    $query = "SELECT TransactionID  FROM transaction WHERE AccountNumber = $tr_ac_no AND CardNumber = $tr_card_no AND Date = $tr_date AND Time = $tr_time AND Status = '-1'";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1[0];
}
function generateTransactionId() {
    // Get the current time in seconds
    $timestamp = time();

    // Generate a short random component
    $randomComponent = mt_rand(100, 999);

    // Combine the timestamp and random component
    $transactionId = $timestamp . $randomComponent;

    return $transactionId;
}
function get_tr_status($trac_id){
    $query = "SELECT Status FROM transaction WHERE TransactionID = $trac_id";
    $data_1 = mysqli_query(db_con(), $query);
    $result_1 = mysqli_fetch_all($data_1);
    // print_r($result_1);
    return $result_1[0][0];
}
?>