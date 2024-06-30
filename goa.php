<?php 
$params = array(
    'engine' => 'google_hotels',
    'q' => 'goa',
    'check_in_date' => '2024-03-21',
    'check_out_date' => '2024-03-22',
    'adults' => 1,
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
        
        
        $html .= '<div class="hotel-content">'; // Added a container for hotel content
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
        $html .= '<p><strong>Amenities:</strong></p>';
        $html .= '<ul>';
        if (isset($hotel['amenities']) && is_array($hotel['amenities'])) {
            foreach ($hotel['amenities'] as $amenity) {
                $html .= '<li>' . $amenity . '</li>';
            }
        }
        $html .= '</ul>';
        
        // Nearby places
        $html .= '<p><strong>Nearby Places:</strong></p>';
        $html .= '<ul>';
        if (isset($hotel['nearby_places']) && is_array($hotel['nearby_places'])) {
            foreach ($hotel['nearby_places'] as $place) {
                if (isset($place['transportations'][0]['type'], $place['transportations'][0]['duration'])) {
                    $html .= '<li>' . $place['name'] . ' (' . $place['transportations'][0]['type'] . ' - ' . $place['transportations'][0]['duration'] . ')</li>';
                }
            }
        }
        $html .= '</ul>';
        
        // Rating
        if (isset($hotel['overall_rating'])) {
            $html .= '<p>Overall Rating: ' . $hotel['overall_rating'] . '</p>';
        }
        $html .= '</div>'; // Close hotel-content
        
        // Hotel images
        if (isset($hotel['images']) && is_array($hotel['images'])) {
            $html .= '<div class="hotel-images-slider">';
            $html .= '<h3>Hotel Images:</h3>';
            $html .= '<div class="slider-container">';
            $html .= '<div class="slider">';
            foreach ($hotel['images'] as $image) {
                $html .= '<img class="slide" src="' . $image['original_image'] . '" alt="Hotel Image">';
            }
            $html .= '</div>'; // Close slider div
            $html .= '</div>'; // Close slider-container div
            $html .= '</div>'; // Close hotel-images-slider div
        }
        
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
?>
<style>
.hotel > * {
    margin-bottom: 10px;
}

/* Container for hotel content */
.hotel-content {
    flex: 1; /* Grow to fill available space */
}

/* Hotel images */
.hotel-images-slider {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
    overflow-x: auto;
    white-space: nowrap;
}

.slider-container {
    display: inline-block;
    vertical-align: top;
}

.slide {
    width: 200px;
    height: 150px;
    margin-right: 10px;
    border-radius: 5px;
    overflow: hidden;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>