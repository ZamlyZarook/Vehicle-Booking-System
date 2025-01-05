<?php
session_start(); // Starting Session

if (isset($_SESSION['login_agency'])) {
    header("location: ../home/index.php"); // Redirecting to the dashboard if already logged in
    exit; // Ensure the script stops here
}

require '../config/connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $agency_username = $_POST['agency_username'];
    $agency_password = $_POST['agency_password'];

    $conn = Connect(); // Establish database connection

    // Prepare a SQL query (replace 'your_table' with the actual table name)
    $query = "SELECT * FROM agency WHERE agency_username = ? AND agency_password = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $agency_username, $agency_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Valid login, set the session
        $_SESSION['login_agency'] = $agency_username;
        $stmt->close();
        $conn->close();
        header("location: ../home/index.php"); // Redirect after successful login
        exit;
    } else {
        // Invalid login, show an error message
        $error_message = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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
        <div class="">
            <ul>
                <li><a class="nav-bar"  href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_customer']; ?></a></li>

                        <li><a class="nav-bar"  href="../user/pre_return_vehicle.php">Return Now</a></li>
                        <li><a class="nav-bar"  href="../user/mybookings.php"> My Bookings</a></li>
                <li><a class="nav-bar"  href="../config/logout.php">Logout</a></li>
            </ul>
        </div>
    <?php
    } else {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar"  href="../home/index.php">Home</a></li>
                <li><a class="nav-bar"  href="../admin/admin_login.php">Admin Login</a></li>
                <li><a class="nav-bar"  href="../user/user_login.php">Customer Login</a></li>
            </ul>
        </nav>
    <?php
    }
    ?>


    <br><br><br>

    <div class="form-page">
        <h1>Admin Login</h1>

        <form method="post">
            <label for="agency_username">Username:</label>
            <input type="text" name="agency_username" id="agency_username" required><br>
            <label for="agency_password">Password:</label>
            <input type="password" name="agency_password" id="agency_password" required><br>
            <input type="submit" value="Login">

            <p class="para">Don't have an account? <span><a href="admin_registration.php">Sign Up</a></span></p>

            <?php
                if (isset($error_message) && !empty($error_message)) {
                    echo '<p class="error">' . $error_message . '</p>';
                    $error_message = ""; // Clear the error message
                }
                ?>
        </form>
        <br><br>
    <div>

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
