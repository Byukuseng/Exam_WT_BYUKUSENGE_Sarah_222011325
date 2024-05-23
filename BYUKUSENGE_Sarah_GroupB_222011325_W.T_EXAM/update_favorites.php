<?php

include('db_connection.php');

// Check if favorite_id is set
if(isset($_REQUEST['favorite_id'])) {
    $favoriteID = $_REQUEST['favorite_id'];
   
    $stmt = $connection->prepare("SELECT * FROM favorites WHERE favorite_id=?");
    $stmt->bind_param("i", $favoriteID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['favorite_id'];
        $y = $row['campaign_id'];
        $f = $row['user_id'];
        $w = $row['timestamp'];
    } else {
        echo "Favorite not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update favorites</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update favorites form -->
    <h2><u>Update Form of favorites</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Campaign ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="uid">User ID:</label>
        <input type="number" name="uid" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="time">Timestamp:</label>
        <input type="text" name="time" value="<?php echo isset($w) ? $w : ''; ?>">
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
    $time = $_POST['time'];
    
    // Update the favorite in the database
    $stmt = $connection->prepare("UPDATE favorites SET campaign_id=?, user_id=?, timestamp=? WHERE favorite_id=?");
    $stmt->bind_param("iisi", $cid, $uid, $time, $favoriteID);
    $stmt->execute();
  
    // Redirect to favorites.php
    header('Location: favorites.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
