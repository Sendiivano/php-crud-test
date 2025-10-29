<?php
$servername = "localhost";
$username = "root";
$password = ""; // leave empty in XAMPP
$dbname = "testdb"; // make sure this database exists in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
