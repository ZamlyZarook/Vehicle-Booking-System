<?php

function Connect()
{
	$dbhost = "localhost:3310";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "vehicle_booking";

	//Create Connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

	return $conn;
}
?>