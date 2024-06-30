
<?php
    session_start(); // Start the session
   
    ?>
    
    <!DOCTYPE html>
<html>
<head>
    <title>Tours And Travels</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">  
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
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
        .container {
            width: 90%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        form {
            display: none;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 45%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: black;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #333;
        }
        span {
            color:red;
            font-weight: bold; /* Corrected typo here */
            font-size: 22px;
        }
        h1 {
            text-align:center;
            font-family: "Lucida Console", "Courier New", monospace;
}
.container1 {
    width:100%;
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 50px;
        
    }

    .box {
        position: relative;
        overflow: hidden;
        width: 300px;
        height: 230px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .box:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    .box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .box h3 {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        margin: 0;
        padding: 5px;
        color: white;
        text-align: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .box:hover h3 {
        opacity: 1;
    }
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            margin-top:60px;
            border-radius:10px;
        }
        footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 24px;
        }
        footer p {
            margin-bottom: 20px;
            font-size: 18px;
        }
        footer input[type="email"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 250px;
            margin-right: 10px;
        }
        footer button[type="submit"] {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        footer button[type="submit"]:hover {
            background-color: #e53935;
        }
        .service  {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-top: 50px;
    padding-bottom:20px;
}
.flight-info {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-top: 50px;
}

.service-content  .flight-info-content{
    flex: 1;
    padding: 50px;
}

.service-content h2  .flight-info-content h2{
    font-size: 28px;
    margin-bottom: 10px;
}

.service-content p  .flight-info-content p{
    font-size: 18px;
    margin-bottom: 20px;
}

.service-content .btn  {
    padding: 10px 20px;
    background-color: #f44336;
    color: #fff;
    text-align:center;
    text-decoration: none;
    border-radius: 5px;
    margin-left:450px;
    
    transition: background-color 0.3s ease;
}
.flight-info-content .btn{
    padding: 10px 20px;
    background-color: #f44336;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-left:450px;
    transition: background-color 0.3s ease;
}
.service-content .btn:hover  {
    background-color: #e53935;
}
.flight-info-content .btn:hover {
    background-color: #e53935;
}


   
    </style>
</head>
<body>


    <div class="first">
      <a href="index.php">  <h4>MAKE<span>YOUR</span>TRIP</h4></a>
        <div id="usernameDisplay" >
        <a href="#" onclick="showUsername()"><i class="fa-solid fa-user fa-lg" style="color: #000000;"></i></a>
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
        <!-- Username will be displayed here -->
        </div>


       
    </div>
   
    <header>
        <a href="react.html" ><i class="fa-solid fa-hotel" style="color: #000000;"></i><br>Hotels</a>
        <a href="Flightsearch.php" ><i class="fa-solid fa-plane" style="color: #000000;"></i><br>Flights</a>
        <a href="homestay.php" ><i class="fa-solid fa-house" style="color: #000000;"></i><br>HomeStay & Villas</a>
        <a href="holidaypackage.php" ><i class="fa-solid fa-umbrella-beach" style="color: #000000;"></i><br>Holiday Packages</a>
        <a href="#" onclick="showForm('train')"><i class="fa-solid fa-train-subway" style="color: #000000;"></i><br>Train</a>
        <a href="#" onclick="showForm('bus')"><i class="fa-solid fa-bus" style="color: #000000;"></i><br>Bus</a>
        <a href="#" onclick="showForm('cab')"><i class="fa-solid fa-car" style="color: #000000;"></i><br>Cab</a>
    </header>
    
   

        
        
        
        
        
    <h1><center> Explore the World With Us</h1>
   
    <script>
    function showForm(formName) {
        // Hide all forms
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.style.display = 'none';
        });
        // Show the selected form
        var selectedForm = document.getElementById(formName + 'Form');
        if (selectedForm) {
            selectedForm.style.display = 'flex';
        }
    }
    
</script>
<div class="container1">
        <div class="box">
            <img src="https://images.pexels.com/photos/1291766/pexels-photo-1291766.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Place 1">
            <h3>Switzerland</h3>
        </div>
        <div class="box">
            <img src="https://images.pexels.com/photos/532826/pexels-photo-532826.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Place 2">
            <h3>Paris</h3>
        </div>
        <div class="box">
            <img src="https://images.pexels.com/photos/64271/queen-of-liberty-statue-of-liberty-new-york-liberty-statue-64271.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Place 3">
            <h3>Newyork</h3>
        </div>
        <div class="box">
            <img src="https://images.pexels.com/photos/2166559/pexels-photo-2166559.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Place 4">
            <h3>Bali</h3>
        </div>
    </div>
        <div class="container1">
        <div class="box">
            <img src="https://images.pexels.com/photos/1534411/pexels-photo-1534411.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Place 4">
            <h3>Dubai</h3>
        </div>
        <div class="box">
            <img src="https://images.pexels.com/photos/1337144/pexels-photo-1337144.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Place 4">
            <h3>Hongkong</h3>
        </div>
        <div class="box">
            <img src="https://images.pexels.com/photos/1320686/pexels-photo-1320686.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Place 4">
            <h3>Maldives</h3>
        </div>
        <div class="box">
            <img src="https://images.pexels.com/photos/457937/pexels-photo-457937.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Place 4">
            <h3>Canada</h3>
        </div>
    </div>
    <h1>Our Pacakges</h1>

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Package Slider</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
<style>
    
    .slider {
        height: 100%;
       padding-left:15%;
       width:80%;
        /* Change the height value as needed */
    }
    .package img {
        height: 300px; /* Adjust height of the photos */
        width: 80%;
        padding-left:15%;
        /* Maintain aspect ratio */
    }
    .package h3 {
        width: 80%;
        padding-left:15%;
    }
    .package-details {
        display:flex;
        width: 80%;
        padding-left:15%;
    }
</style>
</head>
<body>
<a href="holidaypackage.php"><div class="slider"></a>
<?php
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='package'>";
        echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
        echo "<h3>" . $row["name"] . "</h3>";
        echo "<div class='package-details'>";
        echo "<button onclick=\"window.location.href='holidaypackage.php';\">Show More</button>";



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
        echo "</div>"; // Close package-details div
        echo "</div>"; // Close package div
    }
} else {
    echo "0 results";
}

$conn->close();
?>
</div> <!-- Close slider div -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function(){
        $('.slider').slick({
            // Slick Carousel options
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 500,
            dots: true,
            arrows: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        });
    });
</script>
</body>
</html>

   
    <footer>
        
            <p>Contact us: archipatel1264@gmail.com</p>
            <p>Follow us:</p>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        
        <br><br>
        
            
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
            
        
        <p>&copy; 2024 Tours And Travels. All rights reserved.</p>
    </footer>



</body>
</html>
