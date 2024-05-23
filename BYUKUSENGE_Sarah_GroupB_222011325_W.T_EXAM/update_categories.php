<?php
include('db_connection.php');

// Check if category_id is set
if(isset($_REQUEST['category_id'])) {
    $categoryID = $_REQUEST['category_id'];
   
    $stmt = $connection->prepare("SELECT * FROM categories WHERE category_id=?");
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoryID = $row['category_id'];
        $name = $row['name'];
    } else {
        echo "Category not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Categories</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update categories form -->
    <h2><u>Update Form of Categories</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        <br><br>
 
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $name = $_POST['name'];
    
    // Update the category in the database
    $stmt = $connection->prepare("UPDATE categories SET name=? WHERE category_id=?");
    $stmt->bind_param("si", $name, $categoryID);
    $stmt->execute();
  
    // Redirect to categories.php
    header('Location: categories.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
