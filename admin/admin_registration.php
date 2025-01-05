<?php 
session_start(); 
require '../config/connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function validateForm() {
            var name = document.forms["registrationForm"]["agency_username"].value;
            var mobile = document.forms["registrationForm"]["agency_mobile"].value;
            var address = document.forms["registrationForm"]["agency_address"].value;
            var password = document.forms["registrationForm"]["agency_password"].value;
            var email = document.forms["registrationForm"]["agency_email"].value;

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
                <li>
                    <ul>
                        <li><a class="nav-bar"  href="add_vehicle.php">Add Vehicle</a></li>
                    </ul>
                </li>
                <li><a class="nav-bar"  href="../config/logout.php">Logout</a></li>
            </ul>
        </nav>
    <?php
    } else if (isset($_SESSION['login_customer'])) {
    ?>
        <div class="">
            <ul>
                <li><a class="nav-bar"  href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                <li>
                    <ul>
                        <li><a class="nav-bar"  href="../user/pre_return_vehicle.php">Return Now</a></li>
                        <li><a class="nav-bar"  href="../user/mybookings.php"> My Bookings</a></li>
                    </ul>
                </li>
                <li><a class="nav-bar"  href="../config/logout.php">Logout</a></li>
            </ul>
        </div>
    <?php
    } else {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar"  href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="admin_login.php">Admin Login</a></li>
                <li><a class="nav-bar"  href="../user/user_login.php">User Login</a></li>
            </ul>
        </nav>
    <?php
    }
    ?> 
    <br><br><br>
    <div class="form-reg">
        <h1>Admin Registration</h1>
        <form class="form" name="registrationForm" action="process_registration_admin.php" onsubmit="return validateForm()" method="post">
            <label for="agency_username">Username:</label>
            <input type="text" name="agency_username" id="agency_username" required><br><br>
            <label for="agency_mobile">Mobile Number (10 digits):</label>
            <input type="text" name="agency_mobile" id="agency_mobile" required><br><br>
            <label for="agency_address">Address:</label>
            <input type="text" name="agency_address" id="agency_address" required><br><br>
            <label for="agency_password">Password (at least 8 characters, letters, numbers, and special characters):</label>
            <input type="password" name="agency_password" id="agency_password" required><br><br>
            <label for="agency_email">Email (e.g., example@example.com):</label>
            <input type="email" name="agency_email" id="agency_email" required><br><br>
            <input type="submit" value="Sign Up">
        </form>
        <br><br><br><br>
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
                <?php echo date("Y"); ?> Vehicle rental System
            </p>
        </div>
</footer>

</body>
</html>
