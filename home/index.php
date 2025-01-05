<?php
session_start();
require '../config/connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vehicle Rental System</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="../css/index.css?v=1.2"> -->
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
                <li><a class="nav-bar" href="index.php">Home</a></li>
                <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_agency']; ?>
                    </a></li>

                <li><a class="nav-bar" href="../admin/add_vehicle.php">Add Vehicle</a></li>
                <li><a class="nav-bar" href="../config/logout.php">Logout</a></li>
            </ul>
        </nav>
        <?php
    } else if (isset($_SESSION['login_customer'])) {
        ?>
            <nav>
                <ul>
                    <li><a class="nav-bar" href="index.php">Home</a></li>
                    <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_customer']; ?>
                        </a></li>

                    <li><a class="nav-bar" href="../user/pre_return_vehicle.php">Return Vehicle</a></li>
                    <li><a class="nav-bar" href="../user/mybookings.php"> My Bookings</a></li>
                    <li><a class="nav-bar" href="../config/logout.php">Logout</a></li>

                </ul>
            </nav>
        <?php
    } else {
        ?>
            <nav>
                <ul>
                    <li><a class="nav-bar" href="index.php">Home</a></li>
                    <li><a class="nav-bar" href="../admin/admin_login.php">Admin Login</a></li>
                    <li><a class="nav-bar" href="../user/user_login.php">User Login</a></li>
                </ul>
            </nav>
        <?php
    }
    ?>

    <section class="menu-content">
        <?php
        $sql1 = "SELECT * FROM vehicles WHERE vehicle_available='yes'";
        $result1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $vehicle_id = $row1["vehicle_id"];
                $vehicle_type = $row1["vehicle_type"];
                $vehicle_number = $row1["vehicle_number"];
                $seating_cap = $row1["seating_cap"];
                $rent_per_day = $row1["rent_per_day"];
                $vehicle_img = $row1["vehicle_img"];
                ?>
                <div class="sub-menu">
                    <img src="<?php echo $vehicle_img; ?>" alt="Vehicle Image" width="250" height="150">
                    <h5><b>
                            <?php echo $vehicle_type; ?>
                        </b></h5>
                    <h6>vehicle Number
                        <?php echo $vehicle_number; ?>
                    </h6>
                    <h6>Seating Capacity:
                        <?php echo $seating_cap; ?>
                    </h6>
                    <h6>Rent Per Day:
                        <?php echo $rent_per_day; ?>
                    </h6>
                    <?php
                    if (isset($_SESSION['login_customer'])) {
                        ?>
                        <a href="../user/booking.php?id=<?php echo $vehicle_id; ?>" class="btn">Book Vehicle</a>
                        <?php
                    } else {
                        ?>
                        <a href="../user/user_login.php" class="btn">Log In to Book</a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
        } else {
            ?>
            <h1>Sorry, No Vehicles available, Please check Later :</h1>
            <?php
        }
        ?>
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