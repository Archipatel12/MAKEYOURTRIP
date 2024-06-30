<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['uname'])) {
    // User is logged in, retrieve the username from the session
    $username = $_SESSION['uname'];

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

    // Prepare and bind the SQL statement with a parameter for security
    $sql = "SELECT uname FROM registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['id']); // Assuming 'id' is the user's ID stored in the session
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Output data of the user
        $row = $result->fetch_assoc();
        echo "Welcome, " . $row["uname"] . "!";
    } else {
        echo "No user found with username: $username";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "User not logged in";
    // Redirect the user to the login page if not logged in
    echo '<a href="login.php">Login</a>';
}
?>
