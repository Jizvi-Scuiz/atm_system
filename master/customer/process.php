<?php
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};
include '../db_connection.php';
include 'function.php';
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;
$action = $_POST['action'];

switch ($action) {
    case 'Add Customer':
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $sql = "INSERT INTO Customer (Name, Address, PhoneNumber) VALUES ('$name', '$address', '$phone')";
        break;

    case 'View Customers':
        $sql = "SELECT * FROM Customer";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["CustomerID"]. " - Name: " . $row["Name"]. " - Address: " . $row["Address"]. " - Phone: " . $row["PhoneNumber"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    // case 'Update Customer':
    //     // Add your logic for updating a customer here
    //     break;

    // case 'Delete Customer':
    //     // Add your logic for deleting a customer here
    //     break;

    // case 'Add ATM':
    //     $location = $_POST['location'];
    //     $cash_on_hand = $_POST['cash_on_hand'];
    //     $status = $_POST['status'];
    //     $sql = "INSERT INTO ATM (Location, CashOnHand, Status) VALUES ('$location', '$cash_on_hand', '$status')";
    //     break;

    // case 'View ATMs':
    //     $sql = "SELECT * FROM ATM";
    //     $result = $conn->query($sql);
    //     if ($result->num_rows > 0) {
    //         while($row = $result->fetch_assoc()) {
    //             echo "ID: " . $row["ATMID"]. " - Location: " . $row["Location"]. " - CashOnHand: " . $row["CashOnHand"]. " - Status: " . $row["Status"]. "<br>";
    //         }
    //     } else {
    //         echo "0 results";
    //     }
    //     $conn->close();
    //     exit;

    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cards linked to account</title>
        <link rel="stylesheet" href="../customer/style.css"> 
    
    </head>
    <body>

<?php

    case 'Add Card':
        
        $card_number = $_POST['card_number'];
        $card_name = $_POST['card_name'];
        $expiry_date = $_POST['expiry_date'];
        $pin = $_POST['pin'];
        $cvv = $_POST['cvv'];
        $current_date = new DateTime();
        $account_number = $_POST['acc_no'];

        if((strlen($card_number) == 16) && (strlen($pin) == 4) && (strlen($cvv) == 3) && ($expiry_date < $current_date)){
            // echo '<pre>';
            // var_dump($_POST);
            // echo '</pre>';
            // die;
            $add_card = add_card($card_number,$card_name,$cvv,$pin,$expiry_date,$account_number);
            ?>
            <Script>alert("Card Added to account")</Script>
            <a href="../customer/index.php">Go Back</a>            
        <?php }
        else{
            header('location:../customer/index.php?msg=Invalid Card');
        }
        break;

    case 'View Cards':
        $account_number = $_POST['acc_no'];
        $sql = "SELECT CardNumber FROM cardaccount WHERE acc_no = $account_number";
        // $result = $conn->query($sql);
        $data = mysqli_query(db_con(), $sql);
        $result = mysqli_fetch_all($data);
        
        if($result){
            $fetch_card_no = $result;
            ?>
            <div class="cards"><center>
            <table class="Table">
                <style>
                    .cards{
                        margin-left: auto;
                        margin-right: auto;
                    }
                    table, th, td {
                        border: 2px solid black;
                        align-content: center;
                    }

                    th, td {
                        padding: 5px;
                    }
                </style>
                <tr>
                    <th>Card Number</th>
                    <th>Name</th>
                    <th>Expiry Date</th>
                    <th>CVV</th>
                </tr>
        <?php 
            foreach($fetch_card_no as $key=>$value){
                $query = "SELECT * FROM atm_card WHERE card_no = $value[0]";
                $data_1 = mysqli_query(db_con(), $query);
                $result_1 = mysqli_fetch_all($data_1);
                if($result_1){
                    foreach($result_1 as $key => $value){
                        echo '<tr>
                            <td>'.$value[1].'</td>
                            <td>'.$value[4].'</td>
                            <td>'.$value[5].'</td>
                            <td>'.$value[3].'</td>    
                        </tr>' ?>
                    <?php }
                }
            
            } ?>
            </table>
                </center>
                </div>
        <?php }
        else{
            echo "Generate and add New Card to your account";
            die;
            // header('location: ../customer/index.php');
        }
        
   
                
        break;

    case 'Generate New Card':
        $account_number = $_POST['acc_no'];
        $get_cus_id = get_id($account_number);
        // echo $get_cus_id;
        $get_name = strtoupper(get_acc_det($get_cus_id));
        // echo strtoupper($get_name);
        // Add your logic for updating a card here
        $newCardNumber = generateATMCardNumber(db_con());
        $randomPin = generateRandomPin();
        $randomCvv = generateRandomCvv();
        $currentDate = new DateTime();

        // Add 5 years to the current date
        $currentDate->modify('+5 years');

        // Format the new date as desired
        $exp_date = $currentDate->format('Y-m-d H:i:s');
        
        $add_card = add_new_card($newCardNumber, $get_name, $randomPin, $randomCvv, $exp_date);
        if($add_card){
            
        ?>
        <script>alert("Card Created\nLink it to ur account")</script>
        <div class="cards">
                <table class="Table">
                    <style>
                        .Table{
                            margin-left: auto;
                            margin-right: auto ;
                        }
                        table, th, td {
                            border: 2px solid black;
                            align-content: center;
                        }

                        th, td {
                            padding: 5px;
                        }
                    </style>
                    <tr>
                        <th>Card Number</th>
                        <th>Name</th>
                        <th>Expiry Date</th>
                        <th>CVV</th>
                        <th>PIN</th>
                        
                    </tr>
                <?php                    
                        echo '<tr>
                            <td>'.$newCardNumber.'</td>
                            <td>'.strtoupper($get_name).'</td>
                            <td>'.$exp_date.'</td>
                            <td>'.$randomCvv.'</td>
                            <td>'.$randomPin.'</td>    
                        </tr>'?>
   
            </table>

            </div>

        <?php }

        // echo "Generated ATM Card Number: " . $newCardNumber;


        break;

    case 'Delete Card':
        // Add your logic for deleting a card here
        break;

    case 'Withdraw':
        echo "Waiting for Admin Response";
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';
        $tr_time = date("h:i:sa");
        $tr_date = date("y-m-d");
        $tr_acc_bal = fetch_acc_bal($_POST['acc_no']);
        $tr_ac_no = $_POST['acc_no'];
        $tr_card_no = $_POST['card_no'];
        $tr_card_exp_date = $_POST['exp_date'];
        $tr_type = $_POST['type'];
        $tr_status = $_POST['status'];
        $tr_amt = $_POST['amount'];
        $ac_no = $_POST['acc_no'];
        // die;

        $log_transac = "INSERT INTO transaction (Date, Time, CardNumber, AccountNumber, acc_bal, Type, Amount, Status)
                VALUES ('$tr_date', '$tr_time', '$tr_card_no', '$tr_ac_no', '$tr_acc_bal', '$tr_type', '$tr_amt', '$tr_status')";
        $result = mysqli_query(db_con(), $log_transac);
        echo '<bt>'.$result;
        break;

    case 'View Accounts':
        $sql = "SELECT * FROM Account";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Account Number: " . $row["AccountNumber"]. " - Balance: " . $row["Balance"]. " - Type: " . $row["Type"]. " - CustomerID: " . $row["CustomerID"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    case 'Update Account':
        // Add your logic for updating an account here
        break;

    case 'Delete Account':
        // Add your logic for deleting an account here
        break;

    case 'Add Transaction':
        $date = $_POST['date'];
        $time = $_POST['time'];
        $atm_id = $_POST['atm_id'];
        $card_number = $_POST['card_number'];
        $type = $_POST['type'];
        $amount = $_POST['amount'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        $sql = "INSERT INTO Transaction (Date, Time, ATMID, CardNumber, Type, Amount, Status, Description) VALUES ('$date', '$time', '$atm_id', '$card_number', '$type', '$amount', '$status', '$description')";
        break;

    case 'View Transactions':
        $sql = "SELECT * FROM Transaction";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["TransactionID"]. " - Date: " . $row["Date"]. " - Time: " . $row["Time"]. " - ATMID: " . $row["ATMID"]. " - CardNumber: " . $row["CardNumber"]. " - Type: " . $row["Type"]. " - Amount: " . $row["Amount"]. " - Status: " . $row["Status"]. " - Description: " . $row["Description"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    case 'Update Transaction':
        // Add your logic for updating a transaction here
        break;

    case 'Delete Transaction':
        // Add your logic for deleting a transaction here
        break;

    case 'Add Log':
        $atm_id = $_POST['atm_id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $message = $_POST['message'];
        $sql = "INSERT INTO Log (ATMID, Date, Time, Message) VALUES ('$atm_id', '$date', '$time', '$message')";
        break;

    case 'View Logs':
        $sql = "SELECT * FROM Log";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["LogID"]. " - ATMID: " . $row["ATMID"]. " - Date: " . $row["Date"]. " - Time: " . $row["Time"]. " - Message: " . $row["Message"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    case 'Update Log':
        // Add your logic for updating a log here
        break;

    case 'Delete Log':
        // Add your logic for deleting a log here
        break;

    
    case 'View Card Accounts':
        $sql = "SELECT * FROM CardAccount";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Card Number: " . $row["CardNumber"]. " - Account Number: " . $row["AccountNumber"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    case 'Delete Card Account':
        // Add your logic for deleting a card account here
        break;

    default:
        echo "Invalid action!";
        $conn->close();
        exit;
}

// if ($conn->query($sql) === TRUE) {
//     // echo "Operation performed successfully";
//     header('location: ../admin/index.php?msg=Success');
    
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

$conn->close();
?>


    

    
</body>
</html>