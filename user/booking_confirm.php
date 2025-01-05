<!DOCTYPE html>
<html>
<?php
include('../config/session_user.php');
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: user_login.php");
}
?>

<?php

// Retrieve the vehicle number from the session
$vehicle_number = isset($_SESSION['vehicle_number']) ? $_SESSION['vehicle_number'] : 'Not booked yet';

?>

<head>
    <title>Book Vehicle </title>
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $no_of_days = $conn->real_escape_string($_POST['no_of_days']);
        $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
        $no_of_days = intval($_POST['no_of_days']);
        $rent_end_date = date('Y-m-d', strtotime($rent_start_date . ' + ' . $no_of_days . ' days'));
        $return_status = "NR"; // not returned

        $customer_username = $_SESSION['login_customer'];
        function dateDiff($start, $end)
        {
            $start_ts = strtotime($start);
            $end_ts = strtotime($end);
            $diff = $end_ts - $start_ts;
            return round($diff / 86400);
        }

        $err_date = dateDiff("$rent_start_date", "$rent_end_date");

        $sql0 = "SELECT * FROM vehicles WHERE vehicle_number = '$vehicle_number'";
        // echo $vehicle_number;
        $result0 = $conn->query($sql0);

        if ($err_date >= 0) {
            $sql0 = "SELECT * FROM vehicles WHERE  vehicle_number = '$vehicle_number'";
            $result0 = $conn->query($sql0);
            $row = $result0->fetch_assoc();
            $rent_per_day = $row['rent_per_day'];
            $vehicle_id = $row['vehicle_id'];
            $vehicle_type = $row['vehicle_type'];


            $sql1 = "INSERT into rentedvehicle(customer_username, vehicle_id, no_of_days, start_date, end_date, rent_per_day, return_status) 
                 VALUES('" . $customer_username . "','" . $vehicle_id . "','" . $no_of_days . "','" . $rent_start_date . "','" . $rent_end_date . "','" . $rent_per_day . "','" . $return_status . "')";
            $result1 = $conn->query($sql1);

            $sql2 = "UPDATE vehicles SET vehicle_available = 'no' WHERE vehicle_number = '$vehicle_number'";
            $result2 = $conn->query($sql2);
        }
    }
    ?>

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

    <br><br>
    <div class="form-reg">
        <h1 style="color: green; text-align:center;">Booking Confirmed.</h1>
        <h2 style="text-align:center;"> Thank you for using Zamly Vehicle Booking. We wish you have a safe ride. </h2>
        <div  style="float: none; margin: 0 auto; text-align: center;">
                <h3 style="color: orange;">Invoice</h3>
        </div>
        <form>
            <lable><strong>Vehicle Type: </strong>
            <?php echo $vehicle_type; ?></lable><br><br>
            <lable><strong>Vehicle Number:</strong>
            <?php echo $vehicle_number; ?></lable><br><br>
            <lable><strong>Vehicle Date: </strong>
            <?php echo date("Y-m-d"); ?></lable><br><br>
            <lable><strong>Start Date: </strong>
            <?php echo $rent_start_date; ?></lable><br><br>
            <lable><strong>Return Date: </strong>
            <?php echo $rent_end_date; ?></lable><br><br>
        </form>
    </div>

<?php {
?>

    <?php } ?>
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