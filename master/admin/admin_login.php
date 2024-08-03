<?php
session_start();
include '../db_connection.php';


if(isset($_POST['submit'])){

   $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);

   if($admin_id == "admin_123" and $pass == "1111"){
      $_SESSION['admin_id'] = $admin_id;
      header('location: ../admin/index.php');
   }else{
    echo '<script>alert("Please Enter Correct Credentials")</script>'; 
   }

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>DBS Bank | Login Page</title>
    <link rel="stylesheet" type="text/css" href="../login.css">

    <script>
      if(window.history.replaceState){
         window.history.replaceState(null,null,window.location.href);
      }
    </script>
</head>
<body>


    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="post">
            <label for="username">Admin ID</label>
            <input type="text" id="username" name="admin_id" required><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login" name="submit">
        </form>
    </div>



    

</body>
</html>
