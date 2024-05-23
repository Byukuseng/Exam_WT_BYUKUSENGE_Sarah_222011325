
<?php
include('db_connection.php');

// Check if update_id is set
if(isset($_REQUEST['update_id'])) {
    $updateID = $_REQUEST['update_id'];
   
    $stmt = $connection->prepare("SELECT * FROM updates WHERE update_id=?");
    $stmt->bind_param("i", $updateID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['update_id'];
        $y = $row['campaign_id'];
        $f = $row['title'];
        $w = $row['description'];
        $p = $row['timestamp'];
    } else {
        echo "Update not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update updates</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update updates form -->
    <h2><u>Update Form of updates</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Campaign ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="desc">Description:</label>
        <input type="text" name="desc" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
 
        <label for="time">Timestamp:</label>
        <input type="text" name="time" value="<?php echo isset($p) ? $p : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $cid = $_POST['cid'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $time = $_POST['time'];
    
    // Update the update in the database
    $stmt = $connection->prepare("UPDATE updates SET campaign_id=?, title=?, description=?, timestamp=? WHERE update_id=?");
    $stmt->bind_param("isssi", $cid, $title, $desc, $time, $updateID);
    $stmt->execute();
  
    // Redirect to updates.php
    header('Location: updates.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
