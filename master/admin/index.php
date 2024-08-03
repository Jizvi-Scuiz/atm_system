<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('location: ../admin/admin_login.php');
}
include '../db_connection.php';
include 'function.php';
if(isset($_GET['msg'])){
    if($_GET['msg'] == 'Success'){
        echo '<script>alert("User added successfully. ")</script>';     
    }

}

$user_id = $_SESSION['admin_id'];
// if(!isset($user_id)){
//    header('location: ../dbs_atm/logins/admin_login.php');
// };

?>


<!DOCTYPE html>
<html>
<head>
    <title>DBS Bank | ATM </title>
    <link rel="stylesheet" href="style.css">
</head>

<style>

#amount-div{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-direction: row;
    font-size: 18px;
}

span {
    display: block;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    width: 50%;
    padding-top: 20px;
    padding-bottom: 20px;
    /* margin-bottom: 20px;
    margin-top: 20px; */
    font-weight: bold;
    /* border: 1px solid #ccc; */

    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
span.requests{
    margin-top: 20px;
    margin-bottom: 20px
}

</style>

<body>

    <nav id="navbar">
        <div class="navbar-content">
            
            <span class="username">
                <?php
                    echo $user_id;
                ?>
                
            </span>
            
                <a href="logout.php?logout=<?php echo $user_id; ?>"><button class="logout-button">Logout</button></a>
        </div>
    </nav>

    <h1 style="margin-bottom: 25px;">DBS BANK ADMIN</h1>
    
    <div class="requests">
        <?php 
        $inactive_accounts = fetch_new_acc();
        // echo '<pre>';
        // var_dump($inactive_accounts);
        // echo '</pre>'; 
        ?>
        <span class="requests">Activate New Accounts</span>
        <table class="Table" style="align-self: center;" border="2px">

            <tr>
                <th>Account Number</th>
                <th>Customer ID</th>
                <th>Status</th>
                <th>Action</th>
                
            </tr>
        <?php
        if($inactive_accounts){
            foreach($inactive_accounts as $key => $value){
                echo '<tr>
                    <td>'.$value[1].'</td>
                    <td>'.$value[4].'</td>
                    <td>'.$value[5].'</td>
                    <td> <form action="activate.php" method="POST">
                        <input type="hidden" name="acc_no" value='.$value[4].'>
                        <button class="btn-primary" type="submit" name="activate">Verify
                    </form></td>    
                </tr>'?>

            <?php }
        } ?>    
        </table>
        <span class="requests">Verify Pending Transactions</span>
        <?php 
            $pending_trans = get_pending_transacs();
            // echo '<pre>';
            // var_dump($pending_trans);
            // echo '</pre>';
        ?>
        <table class="Table" style="align-self: center;" border="2px">

            <tr>
                <th>ID</th>
                <th>Account Number</th>
                <th>Card No</th>
                <th>Account Balance</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Time</th>
                <th>Verify</th>
                <th>Reject</th>
                
            </tr>
            <?php
            if($pending_trans){
            foreach($pending_trans as $key => $value){
                echo '<tr>
                    <td>'.$value[0].'</td>
                    <td>'.$value[4].'</td>
                    <td>'.$value[3].'</td>
                    <td>'.$value[5].'</td>
                    <td>'.$value[6].'</td>
                    <td>'.$value[7].'</td>          
                    <td>'.$value[8].'</td>
                    <td>'.$value[1].'</td>
                    <td>'.$value[2].'</td>
                    <td> <form action="activate.php" method="POST">
                        <input type="hidden" name="tr_id" value='.$value[0].'>
                        <input type="hidden" name="ac_no" value='.$value[4].'>
                        <input type="hidden" name="acc_bal" value='.$value[5].'>
                        <input type="hidden" name="tr_type" value='.$value[6].'>
                        <input type="hidden" name="tr_amt" value='.$value[7].'>
                        <input type="hidden" name="action" value="ver">
                        <button class="btn-primary" type="submit" name="submit">Verify
                    </form>
                    </td>    
                    <td> <form action="activate.php" method="POST">
                        <input type="hidden" name="tr_id" value='.$value[0].'>
                        <input type="hidden" name="ac_no" value='.$value[4].'>
                        <input type="hidden" name="acc_bal" value='.$value[5].'>
                        <input type="hidden" name="tr_type" value='.$value[6].'>
                        <input type="hidden" name="tr_amt" value='.$value[7].'>
                        <input type="hidden" name="action" value="rej">
                        <button class="btn-danger" type="submit" name="submit">Reject
                    </form></td>    
                </tr>'?>

            <?php }
            } ?>    
            </table>

        </div>
    <div id="customer" class="form-section">
        <?php include 'customer.php'; ?>
    </div>
    <div id="atm" class="form-section">
        <?php include 'atm.php'; ?>
    </div>
    <div id="card" class="form-section">
        <?php include 'card.php'; ?>
    </div>
    <div id="withdrawal" class="form-section">
        <?php include 'withdrawal.php'; ?>
    </div>
    <div id="transaction" class="form-section">
        <?php include 'transaction.php'; ?>
    </div>
    <div id="log" class="form-section">
        <?php include 'log.php'; ?>
    </div>
    <div id="card_account" class="form-section">
        <?php include 'card_account.php'; ?>
    </div>

    <script>
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('form-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>


</body>
</html>
