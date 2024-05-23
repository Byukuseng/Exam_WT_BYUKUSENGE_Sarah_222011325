<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>categories table</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: green;
      background-color: orange;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: brown;
    }
    /* Unvisited link */
    a:link {
      color: purple; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: dimgray;
    }

    /* Active link */
    a:active {
      background-color: blue;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1250px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>

   <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>

  </head>

  <header>

<body bgcolor="darkgrey">

  <form method="GET" class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./image/logopictr.jpeg" width="90" height="70" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./categories.php">Categories</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./campaigns.php">Campaigns</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./comments.php">Comments</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./contributions.php">Contributions</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./rewards.php">Rewards</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./favorites.php">Favorites</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./reports.php">Reports</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./likes.php">Likes</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./payments.php">Payments</a></li>

    <li style="display: inline; margin-right: 10px;"><a href="./updates.php">Updates</a></li>
    
  
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
         <a href="login.html">Change Account</a>
         <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
  </ul>

</header>
<section>

<h1><u> Categories Form </u></h1>
<form method="post" onsubmit="return confirmInsert();">

    <label for="category_id">Category ID:</label>
    <input type="number" id="category_id" name="category_id"><br><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <input type="submit" name="add" value="Insert">
  
</form>

<?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO categories(category_id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $category_id, $name);
    // Set parameters and execute
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
   
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information of Categories</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of Categories</h2></center>
    <table border="3">
        <tr>
            <th>Category ID</th>
            <th>Name</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        include('db_connection.php');

        // Prepare SQL query to retrieve all categories
        $sql = "SELECT * FROM categories";
        $result = $connection->query($sql);

        // Check if there are any categories
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $category_id = $row['category_id']; // Fetch the category_id
                echo "<tr>
                    <td>" . $row['category_id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td><a style='padding:4px' href='delete_categories.php?category_id=$category_id'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_categories.php?category_id=$category_id'>Update</a></td> 
                </tr>";
            }

        } else {
            echo "<tr><td colspan='2'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
</body>

</section>


  
<footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024, Designer by:BYUKUSENGE Sarah</h2></b>
  </center>
</footer>
  
</body>
</html>





