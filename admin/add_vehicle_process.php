<?php
include('../config/session_admin.php');


function GetImageExtension($imagetype) {
    if (empty($imagetype)) return false;

    switch ($imagetype) {
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpg';
        case 'image/png': return '.png';
        default: return false;
    }
}

$vehicle_type = $conn->real_escape_string($_POST['vehicle_type']);
$vehicle_number = $conn->real_escape_string($_POST['vehicle_number']);
$seating_cap = $conn->real_escape_string($_POST['seating_capacity']);
$rent_per_day = $conn->real_escape_string($_POST['rent_per_day']);
$vehicle_availability = "yes"; // Set car availability to "yes"

$check_query = "SELECT vehicle_number FROM vehicles WHERE vehicle_number = '$vehicle_number'";
$result = $conn->query($check_query);
if ($result->num_rows > 0) {
    header('Location: add_vehicle.php?success=vehicle with this vehicle number already exists. Please add a different vehicle number.');
    exit;
}
else{

if (!empty($_FILES["vehicle_image"]["name"])) {
    $file_name = $_FILES["vehicle_image"]["name"];
    $temp_name = $_FILES["vehicle_image"]["tmp_name"];
    $imgtype = $_FILES["vehicle_image"]["type"];
    $ext = GetImageExtension($imgtype);
    $imagename = $file_name;
    $target_path = "../uploads/" . $imagename;

    if (move_uploaded_file($temp_name, $target_path)) {
        $query = "INSERT INTO vehicles (vehicle_type, vehicle_number,seating_cap, rent_per_day,  vehicle_img, vehicle_available) 
                  VALUES ('$vehicle_type', '$vehicle_number',  '$seating_cap','$rent_per_day', '$target_path', '$vehicle_availability')";
        $success = $conn->query($query);

        if ($success) {
            // Retrieve the vehicle_id from the newly inserted vehicle
            $vehicle_id = $conn->insert_id;

            // Insert data into agencycars table
            $agency_username = $_SESSION['login_agency'];
            $query2 = "INSERT INTO agencyvehicle (vehicle_id, agency_username) VALUES ('$vehicle_id', '$agency_username')";
            $success2 = $conn->query($query2);
        }
    }
}

}


if (isset($success) && $success) {
    ?>
    <div class="message_container">
        <div class="jumbotron" style="text-align: center;">
        vehicle Added successfully
            <?php echo $conn->error; ?>
            <br><br>
            <a href="add_vehicle.php" class="btn btn-default"> Go Back </a>
        </div>
    </div>
    <?php
    exit;
}

$conn->close();
?>
