<!DOCTYPE html>
<html>
<?php
session_start();
require '../config/connection.php';
$conn = Connect();
?>

<head>
    <title>Return Vehicle</title>
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
                    </a>
                </li>
                <li><a class="nav-bar" href="../admin/add_vehicle.php">Add Car</a></li>
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
                    <li><a class="nav-bar" href="user_login.php">User Login</a></li>
                </ul>
            </nav>
        <?php
    }

    function dateDiff($start, $end)
    {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    $id = $_GET["id"];
    $sql1 = "SELECT v.vehicle_type, v.vehicle_number, rv.start_date, rv.end_date
    FROM rentedvehicle rv
    JOIN vehicles v ON v.vehicle_id = rv.vehicle_id
    WHERE rv.vehicle_id = '$id'";

    $result1 = $conn->query($sql1);
    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $car_name = $row["vehicle_type"];
            $car_nameplate = $row["vehicle_number"];
            $rent_start_date = $row["start_date"];
            $rent_end_date = $row["end_date"];
            $no_of_days = dateDiff("$rent_start_date", "$rent_end_date");
        }
    }
    ?>
    <br><br><br>
    <div class="form-reg">
        <form action="vehicle_returned.php?id=<?php echo $id ?>&start_date=<?php echo $rent_start_date ?>&end_date=<?php echo $rent_end_date ?>"
            method="POST">

            <h1> Journey Details </h1>

            <p> Vehicle:&nbsp;
                <?php echo ($car_name); ?>
            </p>

            <p> Vehicle Number:&nbsp;
                <?php echo ($car_nameplate); ?>
            </p>

            <p> Rent Start Date:&nbsp;
                <?php echo ($rent_start_date); ?>
            </p>

            <p> Rent End Date:&nbsp;
                <?php echo ($rent_end_date); ?>
            </p>

            <?php ?>
            <p> Number of Day(s):&nbsp;
                <?php echo ($no_of_days); ?>
            </p>
            <input type="hidden" name="distance_or_days" value="<?php echo $no_of_days; ?>">
            <?php ?>

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
    <br>

</body>
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
</html>