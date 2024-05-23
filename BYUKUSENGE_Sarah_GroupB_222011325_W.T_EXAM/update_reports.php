<?php

include('db_connection.php');

// Check if report_id is set
if(isset($_REQUEST['report_id'])) {
    $reportID = $_REQUEST['report_id'];
   
    $stmt = $connection->prepare("SELECT * FROM reports WHERE report_id=?");
    $stmt->bind_param("i", $reportID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['report_id'];
        $y = $row['campaign_id'];
        $f = $row['user_id'];
        $w = $row['reason'];
    } else {
        echo "Report not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update reports</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update reports form -->
    <h2><u>Update Form of reports</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Campaign ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="uid">User ID:</label>
        <input type="number" name="uid" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="reason">Reason:</label>
        <input type="text" name="reason" value="<?php echo isset($w) ? $w : ''; ?>">
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
    $reason = $_POST['reason'];
    
    // Update the report in the database
    $stmt = $connection->prepare("UPDATE reports SET campaign_id=?, user_id=?, reason=? WHERE report_id=?");
    $stmt->bind_param("iisi", $cid, $uid, $reason, $reportID);
    $stmt->execute();
  
    // Redirect to reports.php
    header('Location: reports.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
