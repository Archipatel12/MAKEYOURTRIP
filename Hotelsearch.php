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
    <form id="hotelsForm" action="Hotelsearch.php" method="post">
        <input type="text" name="cityCode" required placeholder="Enter Destination" value="<?php echo isset($_POST['cityCode']) ? $_POST['cityCode'] : ''; ?>">
        <input type="submit" value="search Hotels" name="searchHotels">
        </form>
        
<?php
function generateAccessToken() {
    $client_id = 'fbvfL8cz3E1BJkR7OTkGYx5O7THtfAJT';
    $client_secret = 'znXniujbbyn0w1Js';

    $url = 'https://test.api.amadeus.com/v1/security/oauth2/token';
    $data = array(
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret
    );

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => http_build_query($data),
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);

    if (isset($response['access_token'])) {
        return $response['access_token'];
    } else {
        return null;
    }
}

// Function to fetch hotel data
function fetchHotelData($cityCode, $accessToken) {
    $url = "https://test.api.amadeus.com/v1/reference-data/locations/hotels/by-city?cityCode={$cityCode}&radius=5&radiusUnit=KM&hotelSource=ALL";

    // Set up cURL
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $accessToken",
            "Accept: application/json"
        ),
    ));

    // Execute the request
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // Close cURL
    curl_close($curl);

    // Check for errors
    if ($err) {
        echo "Error occurred: " . $err;
        return null;
    } else {
        // Decode the JSON response
        $decodedResponse = json_decode($response, true);
        
        // Check if the data is available
        if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
            return $decodedResponse;
        } else {
            echo 'No hotel data found for the specified city code.';
            return null;
        }
    }
}

// Function to fetch hotel room offers
function fetchHotelRoomOffers($hotelId, $checkinDate, $checkoutDate, $accessToken) {
    $url = "https://test.api.amadeus.com/v3/shopping/hotel-offers?hotelIds={$hotelId}&checkInDate={$checkinDate}&checkOutDate={$checkoutDate}&roomQuantity=1&adults=1&paymentPolicy=NONE";

    // Set up cURL
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $accessToken",
            "Accept: application/json"
        ),
    ));

    // Execute the request
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // Close cURL
    curl_close($curl);

    // Check for errors
    if ($err) {
        echo "Error occurred: " . $err;
        return null;
    } else {
        // Decode the JSON response
        $decodedResponse = json_decode($response, true);

        // Check if the data is available
        if (isset($decodedResponse['data']) && is_array($decodedResponse['data']) && !empty($decodedResponse['data'])) {
            return $decodedResponse['data'][0]['offers']; // Return offers array
        } else {
            echo 'No room offers found for the specified hotel ID.';
            return null;
        }
    }
}

// Check if form is submitted with city code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cityCode'])) {
    $cityCode = $_POST['cityCode'];

    // Generate access token
    $accessToken = generateAccessToken();

    if ($accessToken) {
        // Fetch hotel data
        $hotelData = fetchHotelData($cityCode, $accessToken);

        // Check if data is retrieved successfully
        if ($hotelData !== null && isset($hotelData['data'])) {
            // Start HTML output
            echo '<!DOCTYPE html>';
            echo '<html lang="en">';
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            echo '<title>Hotel Booking</title>';
            echo '<style>';
            echo 'body { font-family:Arial,sans-serif;  font-size:20px;  background-color: #f2f2f2; }';
            
            echo 'form {height: 70px; widht: 90%; border-radius: 10px; padding-top: 40px; padding-left:50px; border: 2px solid black; align-items: center; justify-content:evenly;}';
            echo 'button { color:white;background-color:black; height:30px; margin-left:15px; border-radius:10px;}';
            echo '</style>';
            echo '</head>';
            echo '<body>';
            echo '<h1>Hotel Booking</h1>';
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<label for="hotelId">Select Hotel:</label>';
            echo '<select id="hotelId" name="hotelId" required>';
            foreach ($hotelData['data'] as $hotel) {
                echo '<option value="' . $hotel['hotelId'] . '">' . $hotel['name'] . '</option>';
            }
            echo '</select>';
            echo '<input type="hidden" name="cityCode" value="' . $cityCode . '">';
            echo '<label for="checkinDate">Check-in Date:</label>';
            echo '<input type="date" id="checkinDate" name="checkinDate" required>';
            echo '<label for="checkoutDate">Check-out Date:</label>';
            echo '<input type="date" id="checkoutDate" name="checkoutDate" required>';
            echo '<button type="submit">Select Hotel</button>';
            echo '</form>';
           
            echo '</body>';
            echo '</html>';
        } else {
            echo 'No hotel data found for the specified city code.';
        }
    } else {
        echo "Error occurred: Unable to generate access token.";
    }
}

// Check if form is submitted with hotel ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hotelId']) && isset($_POST['cityCode']) && isset($_POST['checkinDate']) && isset($_POST['checkoutDate'])) {
    $hotelId = $_POST['hotelId'];
    $cityCode = $_POST['cityCode'];

    // Generate access token
    $accessToken = generateAccessToken();

    if ($accessToken) {
        // Fetch hotel room offers
        $roomOffers = fetchHotelRoomOffers($hotelId, $_POST['checkinDate'], $_POST['checkoutDate'], $accessToken);

        // Check if room offers are retrieved successfully
        if ($roomOffers !== null) {
            // Start HTML output
            echo '<!DOCTYPE html>';
            echo '<html lang="en">';
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            echo '<title>Room Offers</title>';
            echo '<style>';
            echo 'body { font-family: Arial, sans-serif; font-size:20px;}';
            echo '.container { max-width: 800px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }';
            echo '.offer { border-bottom: 1px solid #ddd; padding: 20px 0; }';
            echo '.offer:last-child { border-bottom: none; }';
            echo '.hotel-name { font-size: 24px; font-weight: bold; color: #333; margin-bottom: 10px; }';
            echo '.info { font-size: 18px; color: #666; margin-bottom: 5px; }';
            echo '.price { font-size: 20px; font-weight: bold; color: #ff6d38; }';
            echo '</style>';
            echo '</head>';
            echo '<body>';
            echo '<div class="container">';
foreach ($roomOffers as $offer) {
    echo '<div class="offer">';
    echo '<p>Hotel Name: ' . $hotelData['data'][0]['name'] . '</p>';
    echo '<p>Check-in Date: ' . $offer['checkInDate'] . '</p>';
    echo '<p>Check-out Date: ' . $offer['checkOutDate'] . '</p>';
    echo '<p>Description: ' . $offer['room']['description']['text']. '</p>';
    echo '<p>Roomtype: ' . $offer['room']['typeEstimated']['category'] . '</p>'; 
    echo '<p>Price: ' . $offer['price']['total'] . ' ' . $offer['price']['currency'] . '</p>';
    echo '</div>';
}

echo '</div>';
            // End HTML output
            echo '</body>';
            echo '</html>';
        } else {
            echo 'No room offers found for the specified hotel ID.';
        }
    } else {
        echo "Error occurred: Unable to generate access token.";
    }
}
?>
<div class="container1">
    <h1>Top Search Hotels</h1>
    <div class="hotel-box">
        <!-- Hotel 1 -->
        <div class="hotel">
            <img src="data:image/jpeg;base64,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" alt="Hotel 1">
            <div class="hotel-info">
                <h3>Club Mahindra Tungi</h3>
                <p>Location: Lonavala, INDIA</p>
                <p>Price: $1,680 per night</p>
                <button>Book Now</button>
            </div>
        </div>

        <!-- Repeat this block for other hotels -->
        <!-- Hotel 2 -->
        <div class="hotel">
            <img src="https://images.pexels.com/photos/19356058/pexels-photo-19356058/free-photo-of-taj-mahal-palace-hotel-in-mumbai-india.jpeg?auto=compress&cs=tinysrgb&w=400&lazy=load">
            <div class="hotel-info">
                <h3>The Taj Mahal Palace</h3>
                <p>Location: Mumbai, INDIA</p>
                <p>Price: $2,456 per night</p>
                <button>Book Now</button>
            </div>
        </div>

        <!-- Hotel 3 -->
        <div class="hotel">
            <img src="data:image/jpeg;base64,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" alt="Hotel 3">
            <div class="hotel-info">
                <h3>The Radison</h3>
                <p>Location: Manali, INDIA</p>
                <p>Price: $1,450 per night</p>
                <button>Book Now</button>
            </div>
        </div>
</div>
</div>
<div class="container1">
   
    <div class="hotel-box">
        <div class="hotel">
            <img src="https://cf.bstatic.com/xdata/images/hotel/270x200/22148091.webp?k=cadaf2800d8226b8e1e6f8b57a93a7f927f8d9ca4da9eff85aa5213f25a5eff7&o=">
            <div class="hotel-info">
                <h3>Trident Hydrabad</h3>
                <p>Location: Hydrabad, INDIA</p>
                <p>Price: $1,567 per night</p>
                <button>Book Now</button>
            </div>
        </div>
        <div class="hotel">
            <img src="https://cf.bstatic.com/xdata/images/hotel/270x200/328920641.webp?k=01a3e51a5b4398569765d01e504def6892cc8a099b6d78210d8663b23ea3c499&o=">
            <div class="hotel-info">
                <h3>Radison Blu Plaza Delhi Airport</h3>
                <p>Location: Delhi, INDIA</p>
                <p>Price: $3,763 per night</p>
                <button>Book Now</button>
            </div>
        </div>>
        <div class="hotel">
            <img src="https://cf.bstatic.com/xdata/images/hotel/270x200/31159733.webp?k=9e51bf007b416845ad59bbd1d4c40e56f93f828bda157a3c2426e12ea6f6ab7e&o=">
            <div class="hotel-info">
                <h3>The Leela Mumbai</h3>
                <p>Location: Mumbai, INDIA</p>
                <p>Price: $4,657 per night</p>
                <button>Book Now</button>
            </div>
        </div>>
           
    </div>
</div>

<style>
    span {
            color:red;
            font-weight: bold; /* Corrected typo here */
            font-size: 22px;
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
        form {
            height:60px;
            width:90%;
            border: 3px solid black;
            border-radius:5px;
            padding-top:20px;
            padding-left:30px;
            margin-left:20px;
            justify-content:space-around;
        }
        input[type="text"] {
            width:20%;
            height:40px;
            border:1px solid black;
            border-radius:5px;
        }
        input[type="submit"] {
            width:15%;
            height:40px;
            border:1px solid black;
            background-color:black;
            color:white;
            border-radius:5px;
        }
        
    h1 {
        text-align: center;
    }

    .container1 {
    max-width: 1500px;
    margin: 0 auto;
    padding: 0 20px;
    
}

.hotel-box {
    display: flex;
    flex-wrap: nowrap; /* Ensure all hotels stay in one line */
    overflow-x: auto; /* Add horizontal scroll if needed */
    gap: 20px;
    padding-bottom: 20px; /* Add some bottom padding */
}

.hotel {
    width: 33.33%;
    flex: 0 0 auto; /* Prevent flex items from growing */
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.hotel img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.hotel-info {
    padding: 15px;
}

.hotel-info h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.hotel-info p {
    margin: 5px 0;
    font-size: 14px;
    color: #666;
}

.hotel-info button {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #000;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.hotel-info button:hover {
    background-color: #333;
}

        </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
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