<form action="process.php" method="post">
    <h2>Add Existing Card</h2>
    <label>Card Number:</label><input type="text" name="card_number"><br>
    <label>Name on card</label><input type="text" name="card_name"><br>
    <label>Expiry Date:</label><input type="date" name="expiry_date"><br>
    <label>cvv</label><input type="text" name="cvv"><br>
    <label>pin</label><input type="text" name="pin"><br>
    <input type="hidden" name="acc_no" value="<?php echo get_account_No($user_id); ?>">  
    <div class="center_align">
        <input type="submit" name="action" value="Add Card">
        <input type="submit" name="action" value="View Cards">
        <input type="submit" name="action" value="Generate New Card">
    </div>
    <!-- <input type="submit" name="action" value="Delete Card"> -->
</form>
