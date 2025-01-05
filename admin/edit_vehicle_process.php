<?php
include('../config/session_admin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicle_id = $_POST['vehicle_id'];
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_number = $_POST['vehicle_number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];
    $vehicle_img = $_FILES['vehicle_image']['name'];

    // Check if the new vehicle number is already present in the cars table
    $sql_check_duplicate = "SELECT vehicle_id FROM vehicles WHERE vehicle_number = '$vehicle_number' AND vehicle_id != $vehicle_id";
    $result_check_duplicate = $conn->query($sql_check_duplicate);

    if ($result_check_duplicate->num_rows > 0) {
        // Display JavaScript alert
        echo '<script>alert("Vehicle number already exists");</script>';
        
        // Redirect to the edit_vehicle.php page with an error message
        echo '<script>window.location.href = "edit_vehicle.php?vehicle_id=' . $vehicle_id . '&error=Vehicle number already exists";</script>';
        exit();
    }

    $sql_update_vehicle = "UPDATE vehicles SET
                        vehicle_type = '$vehicle_type',
                        vehicle_number = '$vehicle_number',
                        seating_cap = '$seating_capacity',
                        rent_per_day = '$rent_per_day',
                        vehicle_img = CONCAT('../uploads/', '$vehicle_img')  -- Concatenate 'uploads/' here
                        WHERE vehicle_id = $vehicle_id";

    if ($conn->query($sql_update_vehicle) === TRUE) {
        // Move uploaded file to desired directory
        move_uploaded_file($_FILES['vehicle_image']['tmp_name'], 'uploads/' . $vehicle_img);

        // Display JavaScript alert
        echo '<script>alert("Vehicle is Updated!!!");</script>';
        
        // Redirect to the edit_vehicle.php page with a success message
        // header("Location: edit_vehicle.php?vehicle_id=" . $vehicle_id . "&success=vehicle updated successfully");
        echo '<script>window.location.href = "../home/index.php?vehicle_id=' . $vehicle_id . '&success=Vehicle updated successfully";</script>';

        exit();
    } else {
        // Display JavaScript alert
        echo '<script>alert("Error updating Vehicle");</script>';

        // Redirect to the edit_vehicle.php page with an error message
        echo '<script>window.location.href = "edit_vehicle.php?vehicle_id=' . $vehicle_id . '&error=Error updating Vehicle";</script>';
        exit();
    }
} else {
    // Redirect to an error page if the form is not submitted using POST method
    echo '<script>window.location.href = "some_error_page.php";</script>';
    exit();
}
?>
