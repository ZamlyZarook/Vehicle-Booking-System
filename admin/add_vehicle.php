<?php
include('../config/session_admin.php');

// Check if an Admin is not logged in, redirect to a login page
if (!isset($_SESSION['login_agency'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
    // Your PHP code here, such as handling form submissions

    if (isset($_POST['edit_button'])) {
        // Assuming vehicle_id is a variable containing the vehicle ID value
        $vehicle_id = $_POST['vehicle_id']; // Adjust this line based on how your vehicle_id is obtained

        // Redirect to another page with vehicle_id as a query parameter
        header("Location: edit_vehicle.php?vehicle_id=" . urlencode($vehicle_id));
        exit(); // Make sure to exit after the header to prevent further execution
    }
?>

<!DOCTYPE html>
<html>
 
<head>
    <title>Vehicle Booking</title>
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
.styled-table th,
.styled-table td {
    padding: 12px 15px;
    width: 250px;
    text-align: center;
}

.btn{
  background-color: #022d3d;
  color: #fff;
  cursor: pointer;
  padding: 10px;
  border-radius: 8px;
  width: 150px;
}
btn:hover {
  background-color: #4d879b;
}
    </style>
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
                    <li><a class="nav-bar" href="admin_login.php">Admin Login</a></li>
                    <li><a class="nav-bar" href="../user/user_login.php">User Login</a></li>
                </ul>
            </nav>
        <?php
    }
    ?>

    <section> 
        <br><br><br>
        <div class="form-reg">
        <h1 style="text-align:center;">Add New Vehicle</h1>
        <form action="add_vehicle_process.php" method="post" enctype="multipart/form-data">
            <label for="vehicle_type">Vehicle Type:</label>
            <input type="text" name="vehicle_type" required><br>

            <label for="vehicle_number">Vehicle Number:</label>
            <input type="text" name="vehicle_number" required><br>

            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" required><br>

            <label for="rent_per_day">Rent per Day (in Rs):</label>
            <input type="number" name="rent_per_day" required><br>

            <label for="vehicle_image">Vehicle Image:</label>
            <input type="file" name="vehicle_image" accept="image/*" required><br>

            <input type="submit" value="Add Vehicle">
        </form>
        </div>

        <?php
        if (isset($_GET['success'])) {
            echo '<p style="color: green;">' . htmlspecialchars($_GET['success']) . '</p>';
        }
        ?>

    </section>

    <section>
    <div class="form-reg">
    <h1 style="text-align:center;">My Vehicles</h1>
    </div>
        <form method="POST">
            <?php
            // Storing Session
            $user_check = $_SESSION['login_agency'];
            $sql = "SELECT * FROM vehicles WHERE vehicle_id IN (SELECT vehicle_id FROM agencyvehicle WHERE agency_username='$user_check');";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {

            } else {
                ?>
                <h4>
                    <p>No Vehicles available</p>
                </h4>
                <?php
            }
            ?>

            <!-- Display your vehicles in a table -->
            <div class="Containertable">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Vehicle Type</th>
                        <th>Vehicle Number</th>
                        <th>Seating Capacity</th>
                        <th>Rent per Day</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display vehicles from the database
                    $sql_fetch_vehicles = "SELECT * FROM vehicles WHERE vehicle_id IN (SELECT vehicle_id FROM agencyvehicle WHERE agency_username='$user_check');";
                    $result_fetch_vehicles = $conn->query($sql_fetch_vehicles);


                    while ($row = $result_fetch_vehicles->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['vehicle_type']; ?>
                            </td>
                            <td>
                                <?php echo $row['vehicle_number']; ?>
                            </td>
                            <td>
                                <?php echo $row['seating_cap']; ?>
                            </td>
                            <td>
                                <?php echo $row['rent_per_day']; ?>
                            </td>
                            <td>
                                <form style="padding:0px;" method="post" action="">
                                    <input type="hidden" name="vehicle_id" value="<?php echo $row['vehicle_id']; ?>">
                                    <button name="edit_button" type="submit" class="btn">Edit</button>
                                </form>

                                <form method="post" action="add_vehicle.php" style="padding:0px;">
                                    <input type="hidden" name="vehicle_id" value="<?php echo $row['vehicle_id']; ?>">
                                    <button type="submit" name="delete" class="btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php }



                    ?>
                </tbody>
            </table>
            <div>

            <?php
            // Handle delete action
            if (isset($_POST['delete'])) {
                $id = $_POST['vehicle_id'];
                $sql_del = "DELETE FROM vehicles WHERE vehicle_id = $id";
                $result = mysqli_query($conn, $sql_del);

                $sql_del1 = "DELETE FROM agencyvehicle where vehicle_id=$id";
                $result2 = mysqli_query($conn, $sql_del1);


                if ($result && $result2) {
                    echo '<script>window.location = "add_vehicle.php?success=Vehicle deleted successfully";</script>';
                    exit();
                } else {
                    // Handle error, if needed
                    echo 'Error deleting vehicle';
                }
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