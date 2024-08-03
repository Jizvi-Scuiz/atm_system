<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('location: ../admin/admin_login.php');
}
include '../db_connection.php';


$action = $_POST['action'];
// $create_acc = 0;
// $name = $_POST['name'];
// $address = $_POST['address'];
// $phone = mysqli_real_escape_string($conn, $_POST['phone']);
// $password = $_POST['password'];
// $acc_type = $_POST['account_type'];


// $select = mysqli_query($conn, "SELECT * FROM `customer`") or die('query failed');
// $row = mysqli_fetch_assoc($select);
// echo "<pre>";
// var_dump($row);
// echo "</pre>";
// die;
// $id = $row['CustomerID'];


// // Generate a unique account number
// $acc_number = rand(500000000000,599999999999);

// while ($acc_number) {

//     $check_acc_number = mysqli_query($conn, "SELECT * FROM `account` WHERE AccountNumber = '$acc_number'") or die('query failed');
//     if(mysqli_num_rows($check_acc_number) == 0){
        
//         // Insert new account into database
//         $insert = mysqli_query($conn, "INSERT INTO `account` (AccountNumber, Balance, Type, CustomerID) VALUES ('$acc_number', 500, '$acc_type', '$id')") or die('query failed');
//         break;
//     }else{
//         $acc_number = rand(500000000000,599999999999);
//     }
// }




switch ($action) {
    case 'Add Customer':
        
        $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE PhoneNumber = '$phone'") or die('query failed');
        if (mysqli_num_rows($select) > 0) {
            header('location: ../admin/index.php?msg=Existing_Number');
        }
        else{
            $sql = "INSERT INTO Customer (Name, Address, PhoneNumber, password) VALUES ('$name', '$address', '$phone', '$password' )";
            
        }
        
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

    case 'Update Customer':
        // Add your logic for updating a customer here
        break;

    case 'Delete Customer':
        // Add your logic for deleting a customer here
        break;

    case 'Add ATM':
        $location = $_POST['location'];
        $cash_on_hand = $_POST['cash_on_hand'];
        $status = $_POST['status'];
        $sql = "INSERT INTO ATM (Location, CashOnHand, Status) VALUES ('$location', '$cash_on_hand', '$status')";
        break;

    case 'View ATMs':
        $sql = "SELECT * FROM ATM";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["ATMID"]. " - Location: " . $row["Location"]. " - CashOnHand: " . $row["CashOnHand"]. " - Status: " . $row["Status"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    case 'Update ATM':
        // Add your logic for updating an ATM here
        break;

    case 'Delete ATM':
        // Add your logic for deleting an ATM here
        break;

    case 'Add Card':
        $card_number = $_POST['card_number'];
        $expiry_date = $_POST['expiry_date'];
        $customer_id = $_POST['customer_id'];
        $sql = "INSERT INTO Card (CardNumber, ExpiryDate, CustomerID) VALUES ('$card_number', '$expiry_date', '$customer_id')";
        break;

    case 'View Cards':
        $sql = "SELECT * FROM Card";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Card Number: " . $row["CardNumber"]. " - ExpiryDate: " . $row["ExpiryDate"]. " - CustomerID: " . $row["CustomerID"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        exit;

    case 'Update Card':
        // Add your logic for updating a card here
        break;

    case 'Delete Card':
        // Add your logic for deleting a card here
        break;

    case 'Add Account':
        $account_number = $_POST['account_number'];
        $balance = $_POST['balance'];
        $type = $_POST['type'];
        $customer_id = $_POST['customer_id'];
        $sql = "INSERT INTO Account (AccountNumber, Balance, Type, CustomerID) VALUES ('$account_number', '$balance', '$type', '$customer_id')";
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

    case 'Add Card Account':
        $card_number = $_POST['card_number'];
        $account_number = $_POST['account_number'];
        $sql = "INSERT INTO CardAccount (CardNumber, AccountNumber) VALUES ('$card_number', '$account_number')";
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







if(isset($sql)){
    if ($conn->query($sql) === TRUE) {
        // echo "Operation performed successfully";
        header('location: ../admin/index.php?msg=Success');
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();
?>
