<?php
// Define database connection parameters
$dbhost = "localhost"; // Your database host
$dbuser = "root"; // Your database username
$dbpass = ""; // Your database password
$dbname = "registration"; // Your database name

// Create database connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
