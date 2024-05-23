<?php
include('db_connection.php');

// Check if a search term was provided
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Define the SQL queries to search across multiple tables
    $queries = [
        "campaigns" => "SELECT campaign_id FROM campaigns WHERE     campaign_id LIKE '%$searchTerm%'",
        "categories" => "SELECT name FROM categories WHERE name LIKE '%$searchTerm%'",
        "comments" => "SELECT user_id FROM comments WHERE user_id LIKE '%$searchTerm%'",
        "contributions" => "SELECT contribution_id FROM contributions WHERE contribution_id LIKE '%$searchTerm%'",
        "favorites" => "SELECT favorite_id FROM favorites WHERE favorite_id LIKE '%$searchTerm%'",
        "likes" => "SELECT like_id FROM likes WHERE like_id LIKE '%$searchTerm%'",
        "payments" => "SELECT payment_method FROM payments WHERE payment_method LIKE '%$searchTerm%'",
        "reports" => "SELECT report_id FROM reports WHERE report_id LIKE '%$searchTerm%'",
        "rewards" => "SELECT reward_id FROM rewards WHERE reward_id LIKE '%$searchTerm%'",
        "updates" => "SELECT title FROM updates WHERE title LIKE '%$searchTerm%'"
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>";
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
