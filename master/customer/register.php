<?php
include '../db_connection.php';

// function generateRandomNumber() {
//     $number = '';
//     for ($i = 0; $i < $length; $i++) {
//         $number .= random_int(0, 9);
//     }
//     return $number;

    

// }

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $address = mysqli_real_escape_string($conn, $_POST['current_address']);
    $acc_type = mysqli_real_escape_string($conn, $_POST['account_type']);
    $phno = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if phone number already exists
    $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE PhoneNumber = '$phno'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        echo '<script>alert("With this phone number, you already have an account.")</script>';
    } else {
        // Insert new customer into database
        $insert_query = mysqli_query($conn, "INSERT INTO `customer` (Name, Address, PhoneNumber, password) VALUES ('$name', '$address', '$phno', '$pass')") or die('query failed');

        if ($insert_query) {
            // Get the newly created customer ID
            $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE PhoneNumber = '$phno'") or die('query failed');
            $row = mysqli_fetch_assoc($select);
            $id = $row['CustomerID'];

            // Generate a unique account number
            $acc_number = rand(500000000000,599999999999);
            
            while ($acc_number) {

                $check_acc_number = mysqli_query($conn, "SELECT * FROM `account` WHERE AccountNumber = '$acc_number'") or die('query failed');
                if(mysqli_num_rows($check_acc_number) == 0){
                    
                    // Insert new account into database
                    $insert = mysqli_query($conn, "INSERT INTO `account` (AccountNumber, Balance, Type, CustomerID, active_status) VALUES ('$acc_number', 500, '$acc_type', '$id', 0)") or die('query failed');
                    break;
                }else{
                    $acc_number = rand(500000000000,599999999999);
                }
                
            
            }


            
            
            // echo '<script>alert("Your account has been created successfully :)")</script>';

            // Redirect to login page
            header('Location: login.php?msg=Your account has been created successfully');
            exit; // Ensure no further code is executed
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DBS Bank | Register Page</title>
    <link rel="stylesheet" href="login.css">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>
    <div class="login-container">
        <h2>Open Account</h2>
        <form action="" method="post">
            <label for="username">Customer Name</label>
            <input type="text" id="username" name="customer_name" required><br>
            <label for="address">Current Address</label>
            <input type="text" id="address" name="current_address" required><br>
            <label for="ph_no">Phone Number</label>
            <input type="text" id="ph_no" name="phone_number" required><br>
            <label for="acc_type">Account Type</label>
            <div class="select-container">
                <select name="account_type" id="acc_type" required>
                    <option value="">Select Account Type</option>
                    <option value="savings">Savings</option>
                    <option value="current">Current</option>
                </select>
            </div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Submit" name="submit">
            <p>If you have an account, please <a href="login.php">login now</a></p>
        </form>
    </div>
</body>
</html>
