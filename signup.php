<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
<div class="first">
        <h4>MAKE<span>YOUR</span>TRIP</h4>
           
    </div>
   
    <?php
    // PHP code to handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uname = $_POST["uname"];
        $email = $_POST["email"];
        $psw = $_POST["psw"];
        $rpsw = $_POST["rpsw"];

        // Perform your validation here (e.g., password length check)

        if ($psw !== $rpsw) {
            echo "<script>alert('Passwords do not match. Please re-enter your passwords.');</script>";
        } else if (strlen($psw) > 8) {
           echo "<script> alert('please enter only 8 character in password.');</script>";
        }else {
            // Add additional validation checks here if needed

            require_once "database.php";

            $sql = "INSERT INTO registration (uname, email, psw, rpsw) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $uname, $email, $psw, $rpsw);
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Data inserted successfully.');</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Error inserting data into database.');</script>";
                }
            } else {
                echo "<script>alert('Error preparing SQL statement.');</script>";
            }
        }
    }
?>


    <div class="box2">
        <h1>Sign In</h1>
        <form action="signup.php" method="POST" >
            <input type="text" placeholder="Enter Name" name="uname" id="uname" autocomplete="off" required>
            <br><br>
            <input type="text" placeholder="Enter Email" name="email" id="email" autocomplete="off" required>
            <br><br>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" autocomplete="off" required>
            <br><br>
            <input type="password" placeholder="Repeat Password" name="rpsw" id="rpsw" autocomplete="off" required>
            <br><br>
            <div class="si">
                <button type="submit" name="btn" >Sign In</button>
            </div>
        </form>
       <div class="login"><p>If you already have an account, <a href="login.php">Log In</a></p></div> 
    </div>
    

   

    <style>
        h1 {
            margin-left: 10px;
        }
        .box2 {
            margin-top: 50px;
            height: 400px;
            width: 30%;
            margin-left:35%;
            border-radius:10px;
            border: 1px solid black;
        }
        input[type="text"], input[type="password"] {
            border-radius: 10px;
            margin-left: 10px;
            width:90%;
            height: 30px;
        }
        .si button {
            background-color: black;
            color: white;
            margin-left:70%;
            width:30%;
            height:30px;
            border-radius:10px;
            margin-bottom:5px;
            padding-bottom:3px;
            align-items:center;
        }
        .MESSAGE {
            height:100px;
            width:50%;
            text-align:center;
            align-items:center;
            border:1px solid black;
            padding-top:3px;
        }
       .login  a:link {
    color: blue;
    
  }
 .login  a:visited {
    color: blue;
    background-color: transparent;
    text-decoration: none;
  }
  span {
            color:red;
            font-weigth:bolder;
            font-size: 22px;
        }
  

    </style>
</body>
</html>
