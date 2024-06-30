<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
    .package {
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding: 20px;
        display: flex;
    }

    .package img {
        width: 40%;
        height: 300px;
    }

    .package-details {
        margin-top: 10px;
        width: 50%;
        margin-left:20px;
    }
    .form-container {
        display: none;
        width: 350px;
        height: 550px;
        border: 2px solid black;
        padding: 20px;
        box-sizing: border-box;
        margin-left: 400px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .form-container h3 {
        margin-top: 0;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .form-container label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .form-container input[type="email"],
    .form-container input[type="text"],
    .form-container input[type="date"],
    .form-container input[type="number"] {
        width: 90%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container button[type="submit"] {
        width: 100%;
        align-items:center;
        background-color: black;
        color: white;
        heifht:80px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-container button[type="submit"]:hover {
        background-color: #333;
    }
    .package-details h3 {
        margin-top: 0;
    }
    button {
        justify-content:flex-end;
        background-color:black;
        height:25px;
        width:75px;
        border-radius:5px;
        color:white;
    }
    span {
            color:red;
            font-weight: bold; /* Corrected typo here */
            font-size: 22px;
        }
        header {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px 0;
            background-color: #fff;
        }
        header a {
            text-decoration: none;
            color: #000;
        }
        .first {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-bottom: 2px solid #ccc;
        }
        .first h4 {
            font-size: 20px;
            margin: 0;
            padding: 0;
        }
        .first a {
            text-decoration: none;
            color: #000;
        }
</style>
</head>
<body>

<div class="first">
        <a href="index.php"><h4>MAKE<span>YOUR</span>TRIP</h4></a>
        <div id="usernameDisplay" >
        <a href="#" onclick="showUsername()"><i class="fa-solid fa-user fa-lg" style="color: #000000;"></i></a>
       
        <!-- Username will be displayed here -->
        </div>
    </div>
        <header>
        <a href="Hotelsearch.php" onclick="showForm('hotels')"><i class="fa-solid fa-hotel" style="color: #000000;"></i><br>Hotels</a>
        <a href="Flightsearch.php" onclick="showForm('flights')"><i class="fa-solid fa-plane" style="color: #000000;"></i><br>Flights</a>
        <a href="homestay.php" onclick="showForm('homestays')"><i class="fa-solid fa-house" style="color: #000000;"></i><br>HomeStay & Villas</a>
        <a href="holidaypackage.php" ><i class="fa-solid fa-umbrella-beach" style="color: #000000;"></i><br>Holiday Packages</a>
        <a href="index.php" onclick="showForm('train')"><i class="fa-solid fa-train-subway" style="color: #000000;"></i><br>Train</a>
        <a href="index.php" onclick="showForm('bus')"><i class="fa-solid fa-bus" style="color: #000000;"></i><br>Bus</a>
        <a href="index.php" onclick="showForm('cab')"><i class="fa-solid fa-car" style="color: #000000;"></i><br>Cab</a>
    </header>
    
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from HolidayPackages table
$sql = "SELECT * FROM HolidayPackages";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='package'>";
        echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
        echo "<div class='package-details'>";
        echo "<h3>" . $row["name"] . "</h3>";
        echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
        echo "<p><strong>Price:</strong> $" . $row["price"] . "</p>";
        echo "<p><strong>Duration:</strong> " . $row["duration"] . " days</p>";
       
        
        // Fetch destinations for the current package
        $destinations_sql = "SELECT destination_name FROM PackageDestinations WHERE package_id = " . $row["id"];
        $destinations_result = $conn->query($destinations_sql);
        
        if ($destinations_result->num_rows > 0) {
            echo "<p><strong>Destinations:</strong> ";
            while($destination_row = $destinations_result->fetch_assoc()) {
                echo $destination_row["destination_name"] . ", ";
            }
            echo "</p>";
        }

        // Fetch activities for the current package
        $activities_sql = "SELECT activity_name FROM PackageActivities WHERE package_id = " . $row["id"];
        $activities_result = $conn->query($activities_sql);
        
        if ($activities_result->num_rows > 0) {
            echo "<p><strong>Activities:</strong> ";
            while($activity_row = $activities_result->fetch_assoc()) {
                echo $activity_row["activity_name"] . ", ";
              
            }
            echo "</p>";
        }
        echo "<button>book</button>";
        echo "</div>"; // Close package-details div
        echo "</div>"; // Close package div
    }
} else {
    echo "0 results";
}

$conn->close();
?>
<div class="form-container">
    
    <form id="booking-form">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div><br>
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div><br>
        <div>
            <label for="start-date">Starting Date:</label>
            <input type="date" id="start-date" name="start-date" required>
        </div><br>
        <div>
            <label for="end-date">Ending Date:</label>
            <input type="date" id="end-date" name="end-date" required>
        </div><br>
        <div>
            <label for="adults">Number of Adults:</label>
            <input type="number" id="adults" name="adults" min="1" required>
        </div><br>
        <div>
            <button type="submit">Pay to Proceed</button>
        </div>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all book buttons
    var bookButtons = document.querySelectorAll(".package-details button");

    // Add event listener to each book button
    bookButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Hide all packages
            var packages = document.querySelectorAll(".package");
            packages.forEach(function(package) {
                package.style.display = "none";
            });

            // Show booking form
            var formContainer = document.querySelector(".form-container");
            formContainer.style.display = "block";
        });
    });
});


</script>
<script>
    function showUsername() {
            // Ajax request to retrieve username from database
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_username.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var username = xhr.responseText;
                    // Display the retrieved username in the div
                    var usernameDisplay = document.getElementById("usernameDisplay");
                    usernameDisplay.style.display = "block";
                    usernameDisplay.innerHTML = "Hello, " + username + "!";
                }
            };
            xhr.send();
        }
</script>

</body>
</html>
