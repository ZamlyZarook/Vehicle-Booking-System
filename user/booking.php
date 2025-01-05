<!DOCTYPE html>
<html>
<?php
include('../config/session_user.php');
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: user_login.php");
}
?>

<head>
    <title>Book Vehicle </title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body ng-app="">
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
        <h1>Rent Your Vehicle Here</h1>
            <form action="booking_confirm.php" method="POST">

                <?php
                $vehicle_id = $_GET["id"];
                $sql1 = "SELECT * FROM vehicles WHERE vehicle_id = '$vehicle_id'";
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        $vehicle_type = $row1["vehicle_type"];
                        $vehicle_number = $row1["vehicle_number"];
                        $seating_cap = $row1["seating_cap"];
                        $rent_per_day = $row1["rent_per_day"];
                    }
                }
                ?>

                <label>vehicle Type:&nbsp; <b>
                <?php echo ($vehicle_type); ?>
                </b></label>
                <br>

                <label>Vehicle Number:&nbsp;<b>
                <?php echo ($vehicle_number); ?>
                </b></label>
                <br>

                <?php
                $_SESSION['vehicle_number'] = $vehicle_number
                ?>

                <label> Seating capacity:&nbsp;<b>
                <?php echo ($seating_cap); ?>
                </b></label>
                <br>

                <label>
                    Please fill number of days:
                </label>
                <br>

                <input type="number" name="no_of_days" required="">

                <?php $today = date("Y-m-d") ?>
                <label>
                    Start Date:
                </label>
                <input type="date" name="rent_start_date" min="<?php echo ($today); ?>" required="">
                &nbsp;

                <label>Rent Per day: <?php echo ("Rs. " . $rent_per_day); ?></label>

                <input type="hidden" name="hidden_vehicleid" value="<?php echo $vehicle_id; ?>">
                <br>
                <input type="submit" name="submit" value="Rent Now" class="submit">

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