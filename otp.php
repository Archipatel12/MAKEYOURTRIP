<?php
session_start(); // Start the session

if (isset($_POST["verify"])) {
    // Get the entered OTP
    $entered_otp = $_POST["otp"];

    // Check if the entered OTP matches the one stored in the session
    if ($_SESSION["otp"] == $entered_otp) {
        // Redirect to index.php if OTP matches
        header("Location: index.php");
        exit();
    } else {
        // If OTP does not match, display an error message
        echo "<script>alert('Incorrect OTP. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
</head>
<body>
    <div>
        <h2>Verify OTP</h2>
        <form method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <br><br>
            <button type="submit" name="verify">Verify OTP</button>
        </form>
    </div>
</body>
</html>
