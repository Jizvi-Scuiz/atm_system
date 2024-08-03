<?php
session_start();

include '../db_connection.php';


if(isset($_GET['msg'])){
    echo '<script>alert("Your account has been created successfully :)")</script>';
}
if(isset($_POST['submit'])){

   $phno = mysqli_real_escape_string($conn, $_POST['phone_number']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);

   $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE PhoneNumber = '$phno' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['cus_id'] = $row['CustomerID'];
      header('location: ../customer/index.php');
   }else{
    echo '<script>alert("Please Enter Correct Credentials")</script>'; 
   }

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>DBS Bank | Login Page</title>
    <link rel="stylesheet" type="text/css" href="login.css">

    <script>
      if(window.history.replaceState){
         window.history.replaceState(null,null,window.location.href);
      }
    </script>
</head>
<body>


    <div class="login-container">
        <h2>Login Now</h2>
        <form action="" method="post">
            <label for="username">Phone Number</label>
            <input type="text" id="username" name="phone_number" required><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login" name="submit">
            <p>If you are a new user please <a href="register.php">Create Account</a></p>
        </form>
    </div>



    

</body>
</html>
