

<form action="balance_check.php" method="post">
    <?php 
    // echo $acc_no;
    $cards = get_cards_in_acc($acc_no);
    if($cards){
        $pin = get_card_pin($cards[0][0]);
        // echo '<pre>';
        // var_dump($pin);
        // echo '</pre>';
        // die;
        // echo $pin[3];
        // print_r($cards[0][0]);
        $accounts = get_accounts_linked($cards[0][0]);
        
        ?>
        <label>Card Number:</label>
        <input type="text" name="card_no" ?><br>
        <!-- <label for="acc_bal">Select Account to see balance:</label> -->
        <label>Enter Card Holder Name:</label>
        <input type="text" name="card_name_entered" required><br>
        <label>Enter CVV:</label>
        <input type="text" name="cvv" required><br>
        <label>Expiry Date:</label>
        <input type="date" name="exp_date" required><br>       
        <label for="pin_entered">Enter PIN </label><input type="text" name="pin_entered"><br>
        <input type="hidden" name="pin_fetched" value="<?php echo $pin[2]; ?>"><br>
        
        <input type="submit" name="submit" value="Submit">
        <!-- <input type="submit" name="action" value="View Card Accounts">
        <input type="submit" name="action" value="Delete Card Account"> -->

    <?php }else{
        echo "No Cards";
    } ?>
</form>

