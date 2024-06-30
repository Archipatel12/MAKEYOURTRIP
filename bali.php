<?php
$params = array(
    'engine' => 'google_hotels',
    'q' => 'bali',
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
    
    foreach ($hotels as $index => $hotel) {
        $html .= '<div class="hotel">';
        $html .= '<div class="hotel-content">';
        $html .= '<h2>' . $hotel['name'] . '</h2>';
        
        // Description, check-in/out times, prices, amenities, nearby places, rating...
        
        $html .= '</div>'; // Close hotel-content
        
        // Hotel images
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
        
        $html .= '</div>'; // Close hotel
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
/* CSS for hotel list and slider */
/* Define styles for hotel list, hotel box, and hotel images slider here */
<style>
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
</style>
/* End of CSS */
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
