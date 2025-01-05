<?php

include('../config/session_admin.php');

// Check if an agency is not logged in, redirect to a login page
if (!isset($_SESSION['login_agency'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if vehicle_id is provided in the URL
if (!isset($_GET['vehicle_id'])) {
    // Redirect to a page indicating that vehicle_id is missing
    header("Location: ../some_error_page.php");
    exit();
}

// Retrieve vehicle_id from the URL
$vehicle_id = $_GET['vehicle_id'];

// Fetch vehicle details from the database based on vehicle_id
$sql_fetch_vehicle = "SELECT * FROM vehicles WHERE vehicle_id = $vehicle_id";
$result_fetch_vehicle = $conn->query($sql_fetch_vehicle);

if ($result_fetch_vehicle->num_rows > 0) {
    $vehicle_details = $result_fetch_vehicle->fetch_assoc();
} else {
    // Redirect to a page indicating that the vehicle with the provided vehicle_id doesn't exist
    header("Location: ../some_error_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Vehicle</title>
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
                <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_agency']; ?>
                    </a></li>
                <li><a class="nav-bar" href="add_vehicle.php">Add Vehicle</a></li>
                <li><a class="nav-bar" href="../config/logout.php">Logout</a></li>
            </ul>
        </nav>
        <?php
    } else if (isset($_SESSION['login_customer'])) {
        ?>
            <nav>
                <ul>
                    <li><a class="nav-bar" href="../home/index.php">Home</a></li>
                    <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_customer']; ?>
                        </a></li>
                    <li><a class="nav-bar" href="../user/pre_return_vehicle.php">Return Now</a></li>
                    <li><a class="nav-bar" href="../user/mybookings.php"> My Bookings</a></li>
                    <li><a class="nav-bar" href="../config/logout.php">Logout</a></li>
                </ul>
            </nav>
        <?php
    } else {
        ?>
            <nav>
                <ul>
                    <li><a class="nav-bar" href="../home/index.php">Home</a></li>
                    <li><a class="nav-bar" href="../admin/admin_login.php">Admin Login</a></li>
                    <li><a class="nav-bar" href="../user/user_login.php">User Login</a></li>
                </ul>
            </nav>
        <?php
    }
    ?>
    <section>
    <br><br><br>
    <div class="form-reg">
        <h1>Edit Vehicle</h1>
        <form action="edit_vehicle_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
            <label for="vehicle_type">Vehicle Type:</label>
            <input type="text" name="vehicle_type" value="<?php echo $vehicle_details['vehicle_type']; ?>" required><br>

            <label for="vehicle_number">Vehicle Number:</label>
            <input type="text" name="vehicle_number" value="<?php echo $vehicle_details['vehicle_number']; ?>" required><br>

            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" value="<?php echo $vehicle_details['seating_cap']; ?>" required><br>

            <label for="rent_per_day">Rent per Day (in Rs):</label>
            <input type="number" name="rent_per_day" value="<?php echo $vehicle_details['rent_per_day']; ?>" required><br>

            <label for="vehicle_image">Vehicle Image:</label>
            <input type="file" name="vehicle_image" value="<?php echo $vehicle_details['vehicle_img']; ?>" accept="image/*" required><br>

            <input type="submit" value="Update Vehicle">
        </form>


    </section>

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
