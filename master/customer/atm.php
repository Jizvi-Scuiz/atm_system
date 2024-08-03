<form action="process.php" method="post">
    <h2>ATM</h2>
    <label>Location:</label><input type="text" name="location"><br>
    <label>Cash On Hand:</label><input type="text" name="cash_on_hand"><br>
    <label>Status:</label>
    <select name="status">
        <option value="Online">Online</option>
        <option value="Offline">Offline</option>
    </select><br>
    <input type="submit" name="action" value="Add ATM">
    <input type="submit" name="action" value="View ATMs">
    <input type="submit" name="action" value="Update ATM">
    <input type="submit" name="action" value="Delete ATM">
</form>
