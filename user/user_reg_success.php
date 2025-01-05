<?php 
session_start(); 
require '../config/connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration Success</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <div class="form-reg"> 
        <h1>Registration Successful</h1>
        <p>Your registration was successful. You can now log in using your credentials.</p>
        <form>
        <input type="button" value="User Login" onclick="location.href='user_login.php'">
        </form>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
