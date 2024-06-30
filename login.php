<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
<div class="first">
        <h4>MAKE<span>YOUR</span>TRIP</h4>  
    </div>

    <?php
session_start(); // Start the session

if (isset($_POST["btn"])) {
    // Get the values from the form
    $email = $_POST["email"];
    $psw = $_POST["psw"];

    // Include the database connection file
    require_once "database.php";

    // Prepare SQL statement to retrieve user from the database
    $sql = "SELECT * FROM registration WHERE email=? AND psw=?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "ss", $email, $psw);
        // Execute the statement
        mysqli_stmt_execute($stmt);
        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if a user with the provided credentials exists in the database
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result); // Fetch the row
            $_SESSION["id"] = $row["id"];
            $_SESSION["uname"] = $row["uname"];
            header("Location: index.php");
            exit();
        } else {
            // If the user does not exist, display an error message
            echo "<script>alert('Incorrect email or password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Error preparing SQL statement.');</script>";
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

    <div class="contain">
        <form method="POST">
            <input type="text" placeholder="Enter Email" name="email" required>
            <br><br>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <br><br>
            <button type="submit" name="btn">Log In</button>
        </form>
    </div>

    <style>
        .contain {
            height: 180px;
            width: 30%;
            margin-top: 25px;
            margin-left: 35%;
            border: 1px solid black;
            border-radius: 10px;
        }

        input[type="text"] {
            margin-top: 25px;
            border-radius: 10px;
            margin-left: 10px;
            width: 90%;
            height: 30px;
        }

        input[type="password"] {
            border-radius: 10px;
            margin-left: 10px;
            width: 90%;
            height: 30px;
        }

        button {
            background-color: black;
            color: white;
            margin-left: 70%;
            width: 25%;
            height: 30px;
            border-radius: 10px;
        }
        span {
            color:red;
            font-weigth:bolder;
            font-size: 22px;
        }
    </style>
</body>
</html>
