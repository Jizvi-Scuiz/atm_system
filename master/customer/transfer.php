<?php
$cards = get_cards_in_acc($acc_no);
if($cards){
    // $pin = get_card_pin($cards[0][0]);
    // echo '<pre>';
    // var_dump($pin);
    // echo '</pre>';
    // $accounts = get_accounts_linked($cards[0][0]);
    
    ?>
    <form action="transfer_transaction.php" method="post">
        
        <label>Card Number:</label>
        <input type="text" name="card_no" ?><br>
        <label>Amount:</label>
        <input type="number" name= 'qty' required>
        <label>Enter Card Holder Name:</label>
        <input type="text" name="card_name_entered" required><br>
        <label>Enter CVV:</label>
        <input type="text" name="cvv" required><br>
        <label>Expiry Date:</label>
        <input type="date" name="exp_date" required><br>
        <label>Enter PIN:</label>
        <input type="password" name="pin_entered" required><br>
        <!-- <input type="hidden" name="pin_fetched" value="<?php echo $pin[2]; ?>">
        <input type="hidden" name="card_name_fetched" value="<?php echo $pin[4]; ?>">
        <input type="hidden" name="exp_date_fetched" value="<?php echo $pin[5]; ?>">
        <input type="hidden" name="act_stat_fetched" value="<?php echo $pin[6]; ?>"> -->
        
        <input type="submit" name="submit">
    </form>

<?php }
else{
    echo '<label>No cards Linked</label>';
}
?>

