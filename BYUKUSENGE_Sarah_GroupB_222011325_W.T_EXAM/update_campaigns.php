
<?php
include('db_connection.php');

// Check if campaign_id is set
if(isset($_REQUEST['campaign_id'])) {
    $campaignID = $_REQUEST['campaign_id'];
   
    $stmt = $connection->prepare("SELECT * FROM campaign WHERE campaign_id=?");
    $stmt->bind_param("i", $campaignID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $campaignID = $row['campaign_id'];
        $title = $row['title'];
        $description = $row['description'];
        $startDate = $row['start_date'];
        $endDate = $row['end_date'];
        $categoryID = $row['category_id'];
    } else {
        echo "Campaign not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Campaign</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update campaign form -->
    <h2><u>Update Form of Campaign</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
        <br><br>

        <label for="description">Description:</label>
        <input type="text" name="description" value="<?php echo isset($description) ? $description : ''; ?>">
        <br><br>

        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" value="<?php echo isset($startDate) ? $startDate : ''; ?>">
        <br><br>
 
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" value="<?php echo isset($endDate) ? $endDate : ''; ?>">
        <br><br>

        <label for="categoryID">Category ID:</label>
        <input type="number" name="categoryID" value="<?php echo isset($categoryID) ? $categoryID : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $categoryID = $_POST['categoryID'];
    
    // Update the campaign in the database
    $stmt = $connection->prepare("UPDATE campaign SET title=?, description=?, start_date=?, end_date=?, category_id=? WHERE campaign_id=?");
    $stmt->bind_param("sssisi", $title, $description, $startDate, $endDate, $categoryID, $campaignID);
    $stmt->execute();
  
    // Redirect to campaigns.php
    header('Location: campaigns.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
