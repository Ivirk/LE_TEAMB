<?php
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "shjp";

// Create connection
$conn = mysqli_connect($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
