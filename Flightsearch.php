<div class="first">
       <a href="index.php"> <h4>MAKE<span>YOUR</span>TRIP</h4></a>
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
    <form id="flightsForm" action="Flightsearch.php" method="post" >
        <input type="text" required id="sourceLocation" placeholder="source city" name="sourceLocation" value="<?php echo isset($_POST['sourceLocation']) ? $_POST['sourceLocation'] : ''; ?>">
        <input type="text" required id="destinationLocation" placeholder="destination city" name="destinationLocation" value="<?php echo isset($_POST['destinationLocation']) ? $_POST['destinationLocation'] : ''; ?>">
        <input type="date" required id="departureDate" name="departureDate" value="<?php echo isset($_POST['departureDate']) ? $_POST['departureDate'] : ''; ?>"> 
        <input type="number" required id="adults" placeholder="number of adults" name="adults" min="1" value="<?php echo isset($_POST['adults']) ? $_POST['adults'] : ''; ?>">
        <input type="submit" name="searchFlight" value="search flight" > 
        </form>
        <div class="container">
            <div class="left-side">
    <h2>Special Offer</h2>
    <img src="https://images.pexels.com/photos/731217/pexels-photo-731217.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="plane">
    </div>
    <div class="offer-container">
        <p>Get 20% off on the first flight booking</p>
        <button >Book Now</button>
    </div>
</div>
    <div class="flightcontainer">
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
// Function to generate access token



// Function to fetch flight options
function fetchFlightOptions($accessToken) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchFlight'])) {
        $sourceLocation = $_POST['sourceLocation'];
        $destinationLocation = $_POST['destinationLocation'];
        $departureDate = $_POST['departureDate'];
        $adults = $_POST['adults'];

        // Construct the API request URL
        $apiUrl = "https://test.api.amadeus.com/v2/shopping/flight-offers?" . "&originLocationCode=" . urlencode($sourceLocation) . "&destinationLocationCode=" . urlencode($destinationLocation) . "&departureDate=" . $departureDate . "&adults=" . $adults;

        // Send request to fetch flight offers
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $accessToken,
                "Accept: application/json" // Request JSON response
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "Error occurred: " . $err;
        } else {
            $responseData = json_decode($response, true);

            if (isset($responseData['errors'])) {
                // Handle API errors
                foreach ($responseData['errors'] as $error) {
                    echo "API Error: " . $error['title'] . " (Code: " . $error['code'] . ")";
                }
            } elseif (isset($responseData['data']) && !empty($responseData['data'])) {
                // Start building the HTML markup for flight offers
                $html = '<div class="flight-offers">';
                foreach ($responseData['data'] as $offer) {
                    foreach ($offer['itineraries'] as $itinerary) {
                        foreach ($itinerary['segments'] as $segment) {
                            $departureTime = strtotime($segment['departure']['at']);
                            $arrivalTime = strtotime($segment['arrival']['at']);
                            $flightDuration = $arrivalTime - $departureTime;
                            $hours = floor($flightDuration / 3600);
                            $minutes = floor(($flightDuration % 3600) / 60);
                            $html .= '<div class="flight-offer">';
                            $html .= '<span class="offer-id">' . $offer['id'] . '</span>';
                            $html .= '<div class="offer-details">';
                            $html .= '<span class="departure">' . $segment['departure']['iataCode'] . '</span>';
                            $html .=  '<i class="fa-solid fa-arrow-right fa-2xl" style="color: #000000;"></i>';
                            $html .= '<span class="arrival">' . $segment['arrival']['iataCode'] . '</span>';
                            
                            $html .= '</div>';
                            $html .= '<div class="timing">';
                            $html .= '<span class="departure-time">' . $segment['departure']['at'] . '</span>';
                            $html .= 'Duration: ' . sprintf('%02d:%02d', $hours, $minutes); // Display duration as HH:MM format
                            $html .= '<span class="arrival-time">' . $segment['arrival']['at'] . '</span>';
                            $html .= '</div>';
                           
                           
                            $html .= '<div class="carrier">';
                            $airlineNames = [
                                'AA' => 'American Airlines',
                                'DL' => 'Delta Air Lines',
                                'UA' => 'United Airlines',
                                'QR' => 'Quatar Airways',
                                'AA' => 'American Airlines',
    'DL' => 'Delta Air Lines',
    'UA' => 'United Airlines',
    'BA' => 'British Airways',
    'LH' => 'Lufthansa',
    'AF' => 'Air France',
    'TK' => 'Turkish Airlines',
    'EK' => 'Emirates',
    'AI' => 'Air India',
    'SG' => 'service',
    'SQ' => 'Singapore Airlines',
    'QF' => 'Qantas',
    'GF' => 'Gulf Air', // Add 'GF' with its corresponding name
    'UK' => 'Vistara', // Add 'UK' with its corresponding name
    'LX' => 'SWISS', // Add 'LX' with its corresponding name
    'ET' => 'Ethiopian Airlines', // Add 'ET' with its corresponding name
    'EI' => 'Aer Lingus', // Add 'EI' with its corresponding name
    'UL' => 'SriLankan Airlines', // Add 'UL' with its corresponding name
    'EY' => 'Etihad Airways', // Add 'EY' with its corresponding name
    'KL' => 'KLM Royal Dutch Airlines', // Add 'KL' with its corresponding name
    '6X' => 'Airline XYZ',
    'KU' =>  ' Kuwait Airways',
    'MS' => 'EgyptAir',
    'WY' => 'Oman Air',
    'LY' => 'Las Airline',
    'VS' => 'Virgin Atlantic',
    'AC' => 'Air Canada',
    'CX' => 'Cathay Pacific Airways'
                                // Add more carrier code to airline name mappings as needed
                            ];
                            $html .= '<span>' . $airlineNames[$segment['carrierCode']] . '</span>';
                            $html .= '<span class="seats">' . $offer['numberOfBookableSeats'] . ' Seats</span>';
                            $html .= '</div>';
                            $html .= '<div class="price">';
                            $html .= 'Price: $' . $offer['price']['total'] . ' ' . $offer['price']['currency']; // Display price
                            $html .= '</div>';
                            $html .= '</div>';
                        }
                    }
                }
                $html .= '</div>';
                echo $html;
            } else {
                echo 'No flight offers found for the specified criteria.';
            }
        }
    }
}

// Generate access token
$accessToken = generateAccessToken();

// Fetch flight options using the generated access token
fetchFlightOptions($accessToken);
?>

  </div>
  <style>
    .flight-offer {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    width: 90%;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-top:10px;
    margin-left:30px;
}

.offer-details {
    display: flex;
    justify-content:space-between;
    margin-bottom: 10px;
}

.offer-id {
    font-weight: bold;
}

.timing {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.departure-time {
    color: #2ecc71; /* Green color for departure time */
}

.arrival-time {
    color: #2ecc71; /* Red color for arrival time */
}

.carrier {
    display: flex;
    font-style: bold;
    margin-bottom: 10px;
    justify-content:space-between;
}

.price {
    font-weight: bold;
}
span {
            color:red;
            font-weight: bold; /* Corrected typo here */
            font-size: 22px;
        }
.arrow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 10px solid #34495e; /* Dark blue color for arrow */
}
.first {
           display:flex;
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
        input[type="date"] {
            width:20%;
            height:40px;
            border:1px solid black;
            border-radius:5px;
        }
        input[type="number"] {
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
        .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        display:flex;
        border-radius: 8px;
        height: 400px;
        background-color: #ADD8E6;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
       margin-bottom: 20px;
        margin-top:20px;
        margin-left:40px;
        font-size:50px;
    }
    img {
        heigth:100%;
        width:65%;
        border: 1 px solid black;
        border-radius:5px;
        margin-left:40px;
    }

    .offer-container {
        
        justify-content: center;
        align-items: center;
        padding: 20px;
        border-radius: 10px;
        margin-left:40%;
    }

    p {
        font-size: 50px;
        font-weight: bold;
        color: #333;
        margin-right: 20px;
        
        
    }

    button {
        background-color: #000;
        color: #fff;
        padding: 10px 20px;
        border: none;
        float: right;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top:10px;
    }

    button:hover {
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