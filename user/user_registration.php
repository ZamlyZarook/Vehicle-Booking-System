<?php
session_start();
require '../config/connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html>

<head>

    <title>User Registration</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        function validateForm() {
            var name = document.forms["loginForm"]["name"].value;
            var mobile = document.forms["loginForm"]["mobile"].value;
            var address = document.forms["loginForm"]["address"].value;
            var phone = document.forms["loginForm"]["phone"].value;
            var password = document.forms["loginForm"]["password"].value;
            var email = document.forms["loginForm"]["email"].value;

            // Mobile number validation (10 digits)
            if (mobile === "" || isNaN(mobile) || mobile.length !== 10) {
                alert("Mobile number must be a 10-digit numeric value");
                return false;
            }

            // Password validation (strong password)
            var passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=]).{8,}$/;
            if (password === "" || !password.match(passwordPattern)) {
                alert("Password must be at least 8 characters long and include a combination of letters, numbers, and special characters (@#$%^&+=)");
                return false;
            }

            // Email validation (basic format)
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (email === "" || !email.match(emailPattern)) {
                alert("Please enter a valid email address");
                return false;
            }

            if (name === "") {
                alert("Name must be filled out");
                return false;
            }
            if (address === "") {
                alert("Address must be filled out");
                return false;
            }
            if (phone === "") {
                alert("Phone number must be filled out");
                return false;
            }
        }
    </script>
</head>

<body>
    <header>
            <div class="box">
                <div class="group">
                <div class="overlap-group">
                    <img class="d" src="../uploads/bg2.jpg" />
                    <div class="text-wrapper">BEST VEHICLE FOR</div>
                    <img class="vehicle" src="../uploads/vehicle.png" />
                    <div class="div">Mohamed Zamly</div>
                    <div class="rectangle"></div>
                    <div class="text-wrapper-2">RENT TODAY</div>
                </div>
                </div>
            </div>
        </header>

    <?php
    if (isset($_SESSION['login_agency'])) {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar" href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_agency']; ?></a></li>

                        <li><a class="nav-bar"  href="../admin/add_vehicle.php">Add Vehicle</a></li>
                <li><a class="nav-bar"  href="../config/logout.php">Logout</a></li>
            </ul>
        </nav>
    <?php
    } else if (isset($_SESSION['login_customer'])) {
    ?>
<nav>
                <ul>
                <li><a class="nav-bar"  href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_customer']; ?></a></li>

                        <li><a class="nav-bar"  href="../user/pre_return_vehicle.php">Return Now</a></li>
                        <li><a class="nav-bar"  href="../user/mybookings.php"> My Bookings</a></li>
                <li><a class="nav-bar"  href="../config/logout.php">Logout</a></li>

            </ul>
    </nav>
    <?php
    } else {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar"  href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="../admin/admin_login.php">Admin Login</a></li>
                <li><a class="nav-bar"  href="user_login.php">User Login</a></li>
            </ul>
        </nav>
    <?php
    }
    ?>
    <br><br><br>
    <div class="form-reg">
        <h1>User Registration</h1>
        <form name="loginForm" action="process_registration_user.php" onsubmit="return validateForm()" method="post">
            <label for="customer_username">UserName:</label>
            <input type="text" name="customer_username" id="customer_username" required><br><br>
            <label for="customer_mobile">Mobile Number (10 digits):</label>
            <input type="text" name="customer_mobile" id="customer_mobile" required><br><br>
            <label for="customer_address">Address:</label>
            <input type="text" name="customer_address" id="customer_address" required><br><br>
            <label for="customer_password">Password (at least 8 characters, letters, numbers, and special characters):</label>
            <input type="password" name="customer_password" id="customer_password" required><br><br>
            <label for="customer_email">Email (e.g., example@example.com):</label>
            <input type="email" name="customer_email" id="customer_email" required><br><br>
            <input type="submit" value="Sign Up">

            <p>Already have an account? <span><a href="user_login.php">Login</a></span></p>
        </form>
    </div>

    <footer>
        <div>
            <ul class="social-media">
                <li><a href="#" class="fa fa-facebook"></a></li>
                <li><a href="#" class="fa fa-twitter"></a></li>
                <li><a href="#" class="fa fa-youtube"></a></li>
                <li><a href="#" class="fa fa-instagram"></a></li>
            </ul>
        </div>
        <div>
            <p class="copyright">&copy;
                2024 Vehicle rental System
            </p>
        </div>
    </footer>
</body>

</html>
