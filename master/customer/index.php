<?php
session_start();
if(!isset($_SESSION['cus_id'])){
   header('location: ../customer/login.php');
};
include 'db_connection.php';
include 'function.php';
// $user_id = $_SESSION['user_id'];

$user_id = $_SESSION['cus_id'];
if(isset($_GET['msg'])){
    echo '<center>'.$_GET['msg'].'</center>';    
}

?>



<!DOCTYPE html>
<html>
<head>
    <title>DBS Bank | ATM </title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>

#amount-div{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-direction: row;
    font-size: 18px;
}

</style>

<body>

    <nav id="navbar">
    <div class="navbar-content">DBS BANK</div>
        <div class="navbar-content">
            
            <img src="img/profile.png" alt="Profile Image" class="profile-image">
            <span class="username">
                <?php
                    $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE CustomerID = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($select) > 0){
                        $row = mysqli_fetch_assoc($select);
                        $user_name = $row['Name'];
                        echo $user_name;
                    }
                ?>
                
            </span>
            
                <a href="logout.php?logout=<?php echo $user_id; ?>"><button class="logout-button">Logout</button></a>
        </div>
    </nav>

    <h1>Account Number: <?php echo get_account_No($user_id); ?></h1>
    <?php 
    $x = check_status($user_id);
    $acc_no =  get_account_No($user_id);
    ?>
    <?php if($x == 1){?>
        <div class="nav-buttons">
            <!-- <button onclick="showSection('atm')">ATM</button> -->
            <button onclick="showSection('card')">Card</button>
            <button onclick="showSection('balance')">Balance</button>
            <button onclick="showSection('transfer')">Transfer</button>
            <button onclick="showSection('deposit')">Deposit</button>
            <button onclick="showSection('withdrawal')">Withdrawal</button>
        </div>
    <?php } 
    else{ ?>
        <h3>Account Inactive</h3>
    <?php }?>

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
    <div id="transfer" class="form-section">
        <?php include 'transfer.php'; ?>
    </div>
    <div id="deposit" class="form-section">
        <?php include 'deposit.php'; ?>
    </div>
    <div id="balance" class="form-section">
        <?php include 'balance.php'; ?>
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
