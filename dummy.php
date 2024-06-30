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
        width:80%; 
        margin-left:200px;/* Change the height value as needed */
    }
    .package img {
        height: 300px; /* Adjust height of the photos */
        width: 80%; /* Maintain aspect ratio */
    }
</style>
</head>
<body>
<div class="slider">
<?php
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
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
</script>
</body>
</html>
