<?php
include('db_connection.php');

// Check if payment_id is set
if(isset($_REQUEST['payment_id'])) {
    $paymentID = $_REQUEST['payment_id'];
   
    $stmt = $connection->prepare("SELECT * FROM payments WHERE payment_id=?");
    $stmt->bind_param("i", $paymentID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['payment_id'];
        $y = $row['contribution_id'];
        $f = $row['payment_method'];
        $w = $row['amount'];
    } else {
        echo "Payment not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update payments</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update payments form -->
    <h2><u>Update Form of payments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Contribution ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="method">Payment Method:</label>
        <input type="text" name="method" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
 
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $cid = $_POST['cid'];
    $method = $_POST['method'];
    $amount = $_POST['amount'];
    
    // Update the payment in the database
    $stmt = $connection->prepare("UPDATE payments SET contribution_id=?, payment_method=?, amount=? WHERE payment_id=?");
    $stmt->bind_param("issi", $cid, $method, $amount, $paymentID);
    $stmt->execute();
  
    // Redirect to payments.php
    header('Location: payments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
