<!DOCTYPE html>
<html>
<?php 
session_start();
require '../config/connection.php';
$conn = Connect();
?>

<head>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
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

                        <li><a class="nav-bar"  href="../admin/add_vehicle.php">Add vehicleehicle</a></li>
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
<?php
$id = $_GET["id"];
$start_date=$_GET["start_date"];
$end_date=$_GET["end_date"];



$sql = "SELECT no_of_days, rent_per_day FROM rentedvehicle WHERE vehicle_id = '$id' and start_date='$start_date' and end_date='$end_date'";

$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Check if the row is not empty
    if ($row) {
        // Retrieve values
        $no_of_days = $row['no_of_days'];
        $rent_per_day = $row['rent_per_day'];

        // Output or use the retrieved values as needed
    }
} else {
    echo "Error in the SQL query: " . $conn->error;
}


$sql9 = "SELECT vehicle_type, vehicle_number FROM vehicles WHERE vehicle_id = '$id'";

$result = $conn->query($sql9);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    if ($row) {
        // Retrieve values
        $vehicle_type = $row['vehicle_type'];
        $vehicle_number = $row['vehicle_number'];
    }
} else {
    echo "Error in the SQL query: " . $conn->error;
}



$total_amount = $no_of_days * $rent_per_day;
$return_status = "R";
$login_customer = $_SESSION['login_customer'];


function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$vehicle_return_date=date('Y-m-d');
$extra_days = dateDiff($end_date, $vehicle_return_date);
$total_fine = $extra_days * 200;

$duration = dateDiff($start_date, $end_date);

if ($extra_days > 0 && $total_fine>0) {
    $total_amount = $total_amount + $total_fine;
}




$sql1 = "UPDATE rentedvehicle SET vehicle_return_date='$vehicle_return_date', no_of_days='$no_of_days', total_amount='$total_amount', return_status='$return_status' WHERE vehicle_id = '$id' and start_date='$start_date' and end_date='$end_date'";

$result1 = $conn->query($sql1);

$sql2 = "UPDATE vehicles c, rentedvehicle rc SET c.vehicle_available='yes' WHERE rc.vehicle_id=c.vehicle_id AND rc.customer_username = '$login_customer' AND rc.vehicle_id = '$id'";
$result2 = $conn->query($sql2);


?>
<?php
$login_customer = $_SESSION['login_customer'];

// Update return_status to 'R' in rentedcar table
$sql_update_rentedvehicle = "UPDATE rentedvehicle rc
                         JOIN vehicles c ON rc.vehicle_id = c.vehicle_id
                         SET rc.return_status = 'R',
                         rc.vehicle_return_date='$vehicle_return_date', rc.total_amount='$total_amount'
                         WHERE rc.customer_username = '$login_customer'AND rc.start_date='$start_date' AND rc.end_date='$end_date' AND c.vehicle_available = 'yes'";

$result_update_rentedcar = $conn->query($sql_update_rentedvehicle);

?>

<br><br>
    <div class="form-reg">
    
    <h1>Vehicle Returned</h1>
    <p> Thank you for visiting Zamly Booking! We wish you have a safe ride. </p>
    <form>
    <h3 style="color: orange; text-align:center">Your Bill</h3>
    <p><strong>Vehicle Name: </strong> <?php echo $vehicle_type;?></p>
    <p><strong>Vehicle Number:</strong> <?php echo $vehicle_number; ?></p>
    <p><strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?></p>
    <p><strong>Start Date: </strong> <?php echo $start_date; ?></p>
    <p><strong>Rent End Date: </strong> <?php echo $end_date; ?></p>
    <p><strong>Vehicle Return Date: </strong> <?php echo $vehicle_return_date; ?></p>
    <p><strong>Number of days:</strong> <?php echo $no_of_days; ?>day(s)</p>
    <p><strong>Total Fine:</strong> Rs. <?php echo $total_fine; ?>/- for <?php echo $extra_days;?> extra days.</p>
    <p><strong>Total Amount: </strong> Rs. <?php echo $total_amount; ?>/-</p>
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