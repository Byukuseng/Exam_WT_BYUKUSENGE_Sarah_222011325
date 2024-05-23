<?php
// Connection details
$host = "localhost";
$user = "SARAH";
$pass = "sarah";
$database = "crowdfunding_platform";

// Create a new database connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection for errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
