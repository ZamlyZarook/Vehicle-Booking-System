<!DOCTYPE html>
<html>
<?php 
session_start();
require '../config/connection.php';
$conn = Connect();
?>
<head>
<title>My Booking</title>
<link rel="stylesheet" href="../css/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.Containertable{
    margin: 0 auto;
    padding-left: 200px;
    padding-right: 200px;
}
.styled-table {
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 1.2em;
  font-family: sans-serif;
  min-width: 300px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
  background-color: #022d3d;
  color: #ffffff;
  text-align: left;
}


.styled-table th,
.styled-table td {
    padding: 12px 15px;
    width: 250px;
}

.styled-table tbody tr {
  border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
  border-bottom: 2px solid #022d3d;
}

.styled-table tbody tr.active-row {
  font-weight: bold;
  color: #009879;
}
</style>
</head>
<body id="page-top">
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
 
<?php 
// isset($_SESSION['login_customer']);
$login_customer=$_SESSION['login_customer']; 

$sql1 = "SELECT * FROM rentedvehicle rv, vehicles v
         WHERE rv.customer_username = '$login_customer' AND v.vehicle_id=rv.vehicle_id AND rv.return_status='R'";

$result1 = $conn->query($sql1);


    if (mysqli_num_rows($result1) > 0) {
?>
    <br><br>
    <div class="form-reg">
        <h1>Your all previous Bookings</h1>
        <p style="text-align:center; color: #022d3d;"> Hope you enjoyed our service </p>
    </div>

    <div class="Containertable">
    <table class="styled-table">
    
  <thead>
<tr>
<th>Vehicle Type</th>
<th>Vehicle Number</th>
<th>Start Date</th>
<th>End Date</th>
<th>Number of Days</th>
</tr>
</thead>
<?php
        while($row = mysqli_fetch_assoc($result1)) {
?>
<tr>
<td><?php echo $row["vehicle_type"]; ?></td>
<td><?php echo $row["vehicle_number"]; ?></td>
<td><?php echo $row["start_date"] ?></td>
<td><?php echo $row["end_date"]; ?></td>
<td><?php echo $row["no_of_days"]; ?> </td>
<!-- <td>Rs.  <?php echo $row["total_amount"]; ?></td> -->
</tr>
<?php        } ?>
</table>
</div> 
        <?php } else {
            ?>

    <div class="form-reg">
        <br><br><br>
        <h1>You have not previously rented any vehicles till now!</h1>
        <p style="text-align:center; color: #022d3d;"> Hope you enjoyed our service </p>
        <br><br><br><br><br><br><br><br><br><br>
    </div>

            <?php
        } ?>   
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