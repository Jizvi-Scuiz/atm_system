<?php if(!isset($_SESSION['admin_id'])){
    header('location: ../admin/admin_login.php');
} ?>

<form action="process.php" method="post">
    <h2>Customer</h2>
    <input type="submit" name="action" value="View Customers">
</form>
