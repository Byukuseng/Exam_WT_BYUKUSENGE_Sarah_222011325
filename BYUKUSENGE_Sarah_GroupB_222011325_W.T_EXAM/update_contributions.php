<?php
include('db_connection.php');

// Check if contribution_id is set
if(isset($_REQUEST['contribution_id'])) {
    $contributionID = $_REQUEST['contribution_id'];
   
    $stmt = $connection->prepare("SELECT * FROM contributions WHERE contribution_id=?");
    $stmt->bind_param("i", $contributionID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['contribution_id'];
        $y = $row['campaign_id'];
        $f = $row['user_id'];
        $w = $row['amount'];
    } else {
        echo "Contribution not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update contributions</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update contributions form -->
    <h2><u>Update Form of contributions</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Campaign ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="uid">User ID:</label>
        <input type="number" name="uid" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="amt">Amount:</label>
        <input type="number" name="amt" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
 
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $cid = $_POST['cid'];
    $uid = $_POST['uid'];
    $amt = $_POST['amt'];
    
    // Update the contribution in the database
    $stmt = $connection->prepare("UPDATE contributions SET campaign_id=?, user_id=?, amount=? WHERE contribution_id=?");
    $stmt->bind_param("iiii", $cid, $uid, $amt, $contributionID);
    $stmt->execute();
  
    // Redirect to contributions.php
    header('Location: contributions.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
