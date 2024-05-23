<?php

include('db_connection.php');

// Check if reward_id is set
if(isset($_REQUEST['reward_id'])) {
    $rewardID = $_REQUEST['reward_id'];
   
    $stmt = $connection->prepare("SELECT * FROM rewards WHERE reward_id=?");
    $stmt->bind_param("i", $rewardID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['reward_id'];
        $y = $row['campaign_id'];
        $f = $row['description'];
        $w = $row['minimum_amount'];
    } else {
        echo "Reward not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update rewards</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update rewards form -->
    <h2><u>Update Form of rewards</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Campaign ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="desc">Description:</label>
        <input type="text" name="desc" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="min_amount">Minimum Amount:</label>
        <input type="number" name="min_amount" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
 
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $cid = $_POST['cid'];
    $desc = $_POST['desc'];
    $minAmount = $_POST['min_amount'];
    
    // Update the reward in the database
    $stmt = $connection->prepare("UPDATE rewards SET campaign_id=?, description=?, minimum_amount=? WHERE reward_id=?");
    $stmt->bind_param("issi", $cid, $desc, $minAmount, $rewardID);
    $stmt->execute();
  
    // Redirect to rewards.php
    header('Location: rewards.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
