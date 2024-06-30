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
    <form id="homestaysForm" action="homestay.php" method="post" >
          <input type="text" required name="location" placeholder="Enter Location">
          <input type="date" required name="checkin_date" placeholder="Check-in Date">
          <input type="date" required name="checkout_date" placeholder="Check-out Date">
          <select name="num_guests">
              <option value="" disabled selected>Number of Guests</option>
              <option value="1">1 Guest</option>
              <option value="2">2 Guests</option>
              <option value="3">3 Guests</option>
              <!-- Add more options as needed -->
          </select>
          <select name="num_rooms">
              <option value="" disabled selected>Number of Rooms</option>
              <option value="1">1 Room</option>
              <option value="2">2 Rooms</option>
              <option value="3">3 Rooms</option>
              <!-- Add more options as needed -->
          </select>
          <input type="submit" value="Search Homestays">
        </form><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get parameters from form submission
    $location = $_POST["location"];
    $checkin_date = $_POST["checkin_date"];
    $checkout_date = $_POST["checkout_date"];
    $num_guests = $_POST["num_guests"];
    $num_rooms = $_POST["num_rooms"];

    $params = array(
        'engine' => 'google_hotels',
        'q' => $location,
        'check_in_date' => $checkin_date,
        'check_out_date' => $checkout_date,
        'adults' => $num_guests,
        'currency' => 'INR',
        'gl' => 'us',
        'hl' => 'en',
        'api_key' => '09f52e5825cafa3689247775977feae5d0079a2bf9f752a9d17bca5c425695c7'
    );

    // Function to make a request to Google Search API
    function googleSearch($params) {
        $url = 'https://serpapi.com/search?';
        
        // Build query string
        $query = http_build_query($params);
        $url .= $query;
        
        // Make request to API
        $response = file_get_contents($url);
        
        // Decode JSON response
        $data = json_decode($response, true);
        
        return $data;
    }

    // Make the search request
    $results = googleSearch($params);

    // Function to convert JSON data to HTML
    function generateHotelHtml($data) {
        // Check if $data is null or not an array
        if (!is_array($data) || !isset($data['properties'])) {
            return '<p>No hotel data available</p>';
        }
        
        $hotels = $data['properties'];
        if (empty($hotels)) {
            return '<p>No hotels found</p>';
        }

        $html = '<div class="hotel-list">';
        
        foreach ($hotels as $hotel) {
            $html .= '<div class="hotel">';
            
        
            if (isset($hotel['images']) && is_array($hotel['images'])) {
                $html .= '<div class="hotel-images-slider">';
                $html .= '<div class="slider-container">';
                $html .= '<div class="slider">';
                $images = $hotel['images'];
                $currentImageIndex = 0;
                foreach ($images as $image) {
                    if ($currentImageIndex === 0) {
                        $html .= '<img class="slide current" src="' . $image['original_image'] . '" alt="Hotel Image">';
                    } else {
                        $html .= '<img class="slide" src="' . $image['original_image'] . '" alt="Hotel Image">';
                    }
                    $currentImageIndex++;
                }
                $html .= '</div>'; // Close slider div
                $html .= '<button class="prev" onclick="prevSlide(this)">❮</button>';
                $html .= '<button class="next" onclick="nextSlide(this)">❯</button>';
                $html .= '</div>'; // Close slider-container div
                $html .= '</div>'; // Close hotel-images-slider div


            }
            $html .= '<div class="hotel-des">';
            $html .= '<h2>' . $hotel['name'] . '</h2>';
            // Description
            if (isset($hotel['description'])) {
                $html .= '<p>' . $hotel['description'] . '</p>';
            }
            
            if (isset($hotel['check_in_time'])) {
                $html .= '<p>Check-in Time: ' . $hotel['check_in_time'] . '</p>';
            }
            if (isset($hotel['check_out_time'])) {
                $html .= '<p>Check-out Time: ' . $hotel['check_out_time'] . '</p>';
            }


                   
            // Check if prices are available
            if (isset($hotel['prices']) && is_array($hotel['prices'])) {
                $html .= '<p><strong>Prices:</strong></p>';
                $html .= '<ul>';
                
                // Loop through each price
                foreach ($hotel['prices'] as $price) {
                    $html .= '<li>Source: ' . $price['source'] . '</li>';
                    
                    // Check if rate_per_night data is available
                    if (isset($price['rate_per_night'])) {
                        $lowest_price = $price['rate_per_night']['lowest'];
                        $before_taxes_fees = $price['rate_per_night']['before_taxes_fees'];
                        
                        $html .= '<li>Lowest Price: ' . $lowest_price . '</li>';
                        $html .= '<li>Before Taxes & Fees: ' . $before_taxes_fees . '</li>';
                    }
                }
                
                $html .= '</ul>';
            }
            
            

            
            // Amenities
            $html .= '<p><strong>Amenities:</strong><br>';
            if (isset($hotel['amenities']) && is_array($hotel['amenities'])) {
                $html .= implode(", ", $hotel['amenities']);
            }
            $html .= '</p>';
            
            // Nearby places
            $html .= '<p><strong>Nearby Places:</strong><br>';
if (isset($hotel['nearby_places']) && is_array($hotel['nearby_places'])) {
    foreach ($hotel['nearby_places'] as $place) {
        if (isset($place['transportations'][0]['type'], $place['transportations'][0]['duration'])) {
            $html .= $place['name'] . ' (' . $place['transportations'][0]['type'] . ' - ' . $place['transportations'][0]['duration'] . '), ';
        }
    }
    // Remove the trailing comma and space
    $html = rtrim($html, ', ');
}
$html .= '</p>';

            
            // Rating
            if (isset($hotel['overall_rating'])) {
                $html .= '<p>Overall Rating: ' . $hotel['overall_rating'] . '</p>';
            }
            
           // Photo
           $html .= '</div>';
            
            // Add more hotel information here as needed
            
            $html .= '</div>'; // Close hotel div
        }
        
        $html .= '</div>'; // Close hotel-list div
        
        return $html;
    }

    // Check if $results is set before calling generateHotelHtml function
    if (isset($results)) {
        // Assuming $data is your decoded JSON response
        $html = generateHotelHtml($results);
        echo $html;
    } else {
        echo '<p>No hotel data available</p>';
    }
}
?>
<div class="container">
    <div class="hotel-box">
        <div class="hotel-c">
        <img src="https://assets.cntraveller.in/photos/6517fe6930a0eae6e1af230f/master/w_1280,c_limit/slow-garden-17.JPG">
<div class="hotel-info">
    <h3>Slow Garden, Ladakh</h3>
    <p>Slow Garden opened to guests earlier this year, but the property is over 40 years old. Host Tsewang Gyatso wanted it to be a space that feels like home in its sense of privacy, but still gives you the luxury of hotel-style amenities. The homestay has 10 bedrooms spread across three clusters. Gyatso lives in a room in the annex with his dog, Dzee, who is extremely friendly with guests—the homestay is pet-friendly, as well. The food here is focused on local ingredients and regional flavours.</p>
</div>

        </div>
        <div class="hotel-c">
            <img src="https://assets.cntraveller.in/photos/64f852dbde93a1293139a149/master/w_1280,c_limit/Aura_n.jpg">
        <div class="hotel-info">
            <h3>Aura Life, Chandigarh</h3>
            <p>Aura Life, about 25 minutes from the city centre, is a private home that opened to guests in September. Set amid three acres of lush greenery, this sprawling bungalow is spread over two floors. It’s an artist’s home, created by and for artists. Of the four bedrooms at the property, two are open to guests. The first, called Kipling, is muted and minimal in its layout and décor, with an en-suite bathroom featuring handmade ceramics by host Anuja Lath. The second, a blue room on the first floor called Phoenix, is larger and comes with windows overlooking the garden. Here, the family cook prepares meals for the guests, as well. Guest favourites include homestyle dals, kadhai paneer, biryani and other classics like Thai curries, baked vegetables and quesadillas.</p>
        </div></div>
        <div class="hotel-c">
            <img src="https://assets.cntraveller.in/photos/64d0e0a47f4c9f4cc0cc849b/master/w_1280,c_limit/8AFD3647-03BA-446E-840F-A2A6EE964BE8.JPG">
            <div class="hotel-info">
                <h3>Yeto, Uran</h3>
                <p>This two-bedroom property in Uran is meant for Maharashtra cityfolk looking for a break beyond the holy trinity of Lonavala, Khandala and Karjat. The living area has a library with literature on varied subjects and large windows that welcome ample natural light. The bedrooms upstairs are simply furnished, with private patios where you can start your morning with a cup of tea. Plus, art is everywhere in this house—you will find beautiful framed photographs and paintings on every wall; coffee table books on The Beatles; a range of classical and acoustic guitars; as well as a vinyl player with roughly 2,000 records to suit every mood. There’s five different types of meals to pick from: ghar ka khana, a Konkan menu, Irish and Japanese set menus, and a five-course tasting menu.</p>
            </div>
        </div>
        <div class="hotel-c">
            <img src="https://assets.cntraveller.in/photos/64ad18671e94724098a8023a/master/w_1280,c_limit/aarish%20chair.jpg">
            <div class="hotel-info">
                <h3>Aarish, Nainital</h3>
                <p>Not far from the relatively popular mountain communes of Mukteshwar and Dhanachuli, this hillside home was set up by Dev and Deepika Verma during the pandemic. Inspired by the now dwindling Kumaoni bakhaali, Aarish was designed as a long row of rooms with a common porch. The bedrooms are near identical, all equipped with a four-poster bed, a sitting area by a massive glass window that frames the mountain range outside, and a spacious bath, complete with the quintessential brass bucket and jug, bath products and thoughtful additions of feminine hygiene products in colourful, papier-mâché baskets. The team runs a stellar kitchen that whips up everything from cookies and breads to pizzas, jams, jellies and pickles.</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="hotel-box">
        <div class="hotel-c">
        <img src="https://assets.cntraveller.in/photos/649ae5a5608b3bba0708bd92/master/w_1280,c_limit/single%20bed.jpg">
<div class="hotel-info">
    <h3>Hygge House, Manali</h3>
    <p>The quaint four-bedroom cottage (the place can only be booked in its entirety) sits in Raison, steeped in the pastoral charm of the surrounding fruit farm and a cluster of villages on the banks of the Beas River. Its open-plan living and dining rooms feature fine furnishings, a cosy fireplace and floor-to-ceiling windows looking out to the mountains beyond. There’s a wrap-around verandah and an open-air sit-out as well. This homestay is part of the Aramgarh Estate, owned by Manav and Bhanu Khullar. Chefs here treat guests with a selection of North Indian, Himachali and international comfort food..</p>
</div>

        </div>
        <div class="hotel-c">
            <img src="https://assets.cntraveller.in/photos/647dca5112a69330ad420252/master/w_1280,c_limit/salban-3.jpg">
        <div class="hotel-info">
            <h3>Salban Homestay, Kanha</h3>
            <p>When a homestay is hosted by lovers of food, writing, wildlife and travel, it’s hard not to like. Sheema and Jhampan Mookerjee’s Salban is nestled in the village of Baherakhar, at the Mukki gate of Kanha National Park. Surrounded by fruit trees and shaded by large mahua and sal trees, the sprawling bungalow is built in the local style with a red-tiled roof and a large verandah. There are four bedrooms in all: two in the main house and two in an independent cottage flanked by the forest. The hosts cook the meals along with a local couple they trained. Jhampan’s grilled chicken and roast leg of lamb are favourites, and Sheema loves to experiment with local produce through dishes like black rice salad and wild millet fried rice</p>
        </div></div>
        <div class="hotel-c">
            <img src="https://a0.muscache.com/im/pictures/ae1cc304-361c-4e2e-8372-727bd31277c8.jpg?im_w=960">
            <div class="hotel-info">
                <h3>Seeking Slow Farmstay, Naggar</h3>
                <p id="p">A couple of years ago, Swati Seth, a Himachal-based entrepreneur, noticed the demand for clean and safe lodging among female travellers and started hosting them via Airbnb in the spare room of her home near Naggar. Today, two years and a pandemic later, Seth hosts both solo travellers and groups at her beautiful farm-cum-homestay, enveloped by orchards and pine and cedar forests on three sides. Located 3km from the town of Naggar, in the quaint village of Nashala, Seth’s five-bedroom Seeking Slow Farmstay is built using traditional methods and local materials, with wooden floors and ceilings and jharokha-style balconies that offer unhindered views of the peaks around. On the menu here are flavours of Uttar Pradesh, where she grew up, local Himachali, her home of many years, and some classic Western fare.</p>
            </div>
        </div>
        <div class="hotel-c">
            <img src="https://assets.cntraveller.in/photos/641d5d0e80aaec24a37b4189/master/w_1280,c_limit/krishnayan-10.jpg">
            <div class="hotel-info">
                <h3>Krishnayan Heritage, Gwalior</h3>
                <p>Built over a century ago, this haveli lets you embrace Gwalior’s royal past. The two-floor property is built entirely in lime, pink sand and sugar. Its tall arches are supported by sturdy stone pillars that have seen decades of history and several generations of the royal family. Seven rooms—including a two-bedroom suite—are spread across the ground and first floor. Each room features antique Burma teak furniture and paintings, brass artefacts and photographs of the royals over the years. The spacious luxury suite is perfect for families, with two bedrooms, a living room and a large bathroom. Step outside the haveli, and you will find their ‘Dev ghar,’ a small place of worship, along with a temple dedicated to Lord Krishna. While enjoying their homemade Marathi food, don’t miss the mutton pulav, mutton barbat and pickles made with fish and chicken.</p>
            </div>
        </div>
    </div>
</div>
<style>
    .hotel-search {
            width: 80%; /* Adjust width as needed */
            margin: 0 auto; /* Center the container horizontally */
            padding: 20px; /* Add some padding */
            border: 1px solid #ccc; /* Add a border */
            border-radius: 10px; /* Add border-radius for rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            background-color: #f9f9f9; /* Set background color */
        }

        /* Hotel styles */
        .hotel {
            margin-bottom: 20px; /* Add margin between hotels */
            padding: 15px; /* Add padding inside hotels */
            border: 1px solid #ddd; /* Add border around hotels */
            border-radius: 5px; /* Add border-radius for rounded corners */
            background-color: #fff; /* Set background color */
        }
        .hotel-search {
            width: 80%; /* Adjust width as needed */
            margin: 0 auto; /* Center the container horizontally */
            padding: 20px; /* Add some padding */
            border-radius: 10px; /* Add border-radius for rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            background-color: #fff; /* Set background color */
            overflow: hidden; /* Hide overflow content */
        }

        /* Hotel styles */
        .hotel {
            margin-bottom: 20px; /* Add margin between hotels */
            padding: 20px; /* Add padding inside hotels */
            border-radius: 10px; /* Add border-radius for rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            background-color: #f9f9f9; /* Set background color */
            overflow: hidden; 
            width:93%;/* Hide overflow content */
            display:flex;
            display-flex:wrap;
            mardin-left:10px;
        }
.hotel-des {
    margin-left:20px;
}
        /* Title styles */
        .hotel h2 {
            font-size: 24px; /* Set font size */
            color: black; /* Set text color */
            width:100%;
            
            align-items:center;
        }

        /* Description styles */
        .hotel p {
            /* Add margin-top for spacing */
            font-size: 16px; /* Set font size */
            color: black; 
            width:100%;/* Set text color */
        }

        /* Price styles */
        .hotel ul {
            list-style: none; /* Remove default list style */
            padding: 0; /* Remove default padding */
        }

        .hotel li {
            margin-top: 10px; /* Add margin-top for spacing */
            font-size: 16px; /* Set font size */
            color: black;
            width:100%; /* Set text color */
        }
/* Image slider styles */
.slider-container {
    position: relative;
    overflow: hidden;
    width: 300px;
}

.slider {
    display: flex;
    width: 300px;
    height: 300px;
}

.slide {
    flex: 0 0 auto;
    width: 300px;
    transition: transform 0.5s ease;
    display: none; /* Hide all slides initially */
}

.slide.current {
    display: block; /* Show current slide */
}

.button-container {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    color: black;
    font-size: 24px;
    padding: 10px;
    z-index: 2;
}

.prev {
    left: 0;
}

.next {
    right: 0;
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
            width:15%;
            height:40px;
            border:1px solid black;
            border-radius:5px;
        }
        select {
            width:15%;
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
        .container1 {
    width:100%;
    margin: 0 auto;
    padding: 0 20px;
    display:flex;
    
}

.hotel-box {
    
   height:500px;
    gap: 20px;
    display:flex;
    width:100%;
    
    padding-bottom: 20px; /* Add some bottom padding */
}

.hotel-c {
    width: 100%;
    display-flex:wrap;
    background-color: #f7f7f7;
    border-radius: 10px;
   
}

.hotel-c img {
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
    font-size: 10px;
    color: #666;
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
<script>
// JavaScript for image slider
function nextSlide(button) {
    var slider = button.parentNode.querySelector('.slider');
    var slides = slider.querySelectorAll('.slide');
    var currentSlide = slider.querySelector('.current');

    var nextIndex = Array.from(slides).indexOf(currentSlide) + 1;
    if (nextIndex >= slides.length) {
        nextIndex = 0;
    }

    // Hide current slide
    currentSlide.classList.remove('current');

    // Show next slide
    slides[nextIndex].classList.add('current');
}

function prevSlide(button) {
    var slider = button.parentNode.querySelector('.slider');
    var slides = slider.querySelectorAll('.slide');
    var currentSlide = slider.querySelector('.current');

    var prevIndex = Array.from(slides).indexOf(currentSlide) - 1;
    if (prevIndex < 0) {
        prevIndex = slides.length - 1;
    }

    // Hide current slide
    currentSlide.classList.remove('current');

    // Show previous slide
    slides[prevIndex].classList.add('current');
}
</script>
