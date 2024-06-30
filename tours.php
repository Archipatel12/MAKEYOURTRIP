<!DOCTYPE html>
<html>
<head>
    <title>Tours And Travels</title>
    <link rel="stylesheet" href="style.css">
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
        
        span {
            color:red;
            font-weight: bold; /* Corrected typo here */
            font-size: 22px;
        }
        h2 {
            text-align:center;
            font-family: "Lucida Console", "Courier New", monospace;
}
.container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .box {
            width: 200px;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .box img {
            width: 100%;
            height: 170px;
            border-radius: 5px;
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
        /* Existing CSS styles */

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

    <div class="first">
        <h4>MAKE<span>YOUR</span>TRIP</h4>
        <a href="signup.php">Signup</a>
    <!--   <a href="#" onclick="toggleProfileInfo()"><i class="fa-solid fa-user fa-lg" style="color: #000000;"></i></a>   -->
    </div>
    <header>
        <a href="#" ><i class="fa-solid fa-hotel" style="color: #000000;"></i><br>Hotels</a>
        <a href="#" ><i class="fa-solid fa-plane" style="color: #000000;"></i><br>Flights</a>
        <a href="#" ><i class="fa-solid fa-house" style="color: #000000;"></i><br>HomeStay & Villas</a>
        <a href="#" ><i class="fa-solid fa-umbrella-beach" style="color: #000000;"></i><br>Holiday Packages</a>
        <a href="#" ><i class="fa-solid fa-train-subway" style="color: #000000;"></i><br>Train</a>
        <a href="#" ><i class="fa-solid fa-bus" style="color: #000000;"></i><br>Bus</a>
        <a href="#" ><i class="fa-solid fa-car" style="color: #000000;"></i><br>Cab</a>
    </header>
    
        <h2>Explore the World with Us</h2>
        <div class="container">
        <div class="box">
            <img src="https://images.pexels.com/photos/2779863/pexels-photo-2779863.jpeg" alt="Place 1">
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
        <div class="container">
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
    <section class="flight-info">
    <div class="flight-info-content">
        <h2>Explore Our Flight Services</h2>
        <p>Book your flights with ease through our convenient flight booking service. Whether you're planning a business trip or a vacation, we offer a wide range of flight options to suit your needs. Enjoy competitive prices, flexible booking options, and excellent customer service.</p>
        <a href="signup.php" class="btn">Book Now</a>
    </div>
   
</section>

    <section class="service">
    <div class="service-content">
        <h2>Discover Our Hotel Service</h2>
        <p>Experience luxury like never before with our premium travel service. We offer personalized travel packages tailored to your preferences. Whether it's a relaxing beach getaway, an adventurous mountain expedition, or a cultural city tour, we've got you covered.</p>
        <a href="signup.php" class="btn">Explore More</a>
    </div>
    
</section>
    <footer>
        <div>
            <p>Contact us: archipatel1264@gmail.com</p>
            <p>Follow us:</p>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <br>
        <div>
            <form>
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
            </form>
        </div>
        <p>&copy; 2024 Tours And Travels. All rights reserved.</p>
    </footer>


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

</body>
</html>

