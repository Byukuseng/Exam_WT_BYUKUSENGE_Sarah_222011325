<?php
include('db_connection.php');

// Check if comment_id is set
if(isset($_REQUEST['comment_id'])) {
    $commentID = $_REQUEST['comment_id'];
   
    $stmt = $connection->prepare("SELECT * FROM comments WHERE comment_id=?");
    $stmt->bind_param("i", $commentID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['comment_id'];
        $y = $row['campaign_id'];
        $f = $row['user_id'];
        $w = $row['comment'];
    } else {
        echo "Comment not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Comments</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update comments form -->
    <h2><u>Update Form of Comments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cid">Campaign ID:</label>
        <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="uid">User ID:</label>
        <input type="number" name="uid" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        <label for="comment">Comment:</label>
        <input type="text" name="comment" value="<?php echo isset($w) ? $w : ''; ?>">
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
    $comment = $_POST['comment'];
    
    // Update the comment in the database
    $stmt = $connection->prepare("UPDATE comments SET campaign_id=?, user_id=?, comment=? WHERE comment_id=?");
    $stmt->bind_param("iisi", $cid, $uid, $comment, $commentID);
    $stmt->execute();
  
    // Redirect to comments.php
    header('Location: comments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
