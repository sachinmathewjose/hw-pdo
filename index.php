<?php
$servername = "sql2.njit.edu";
$username = "sj555";
$password = "mYSZqqZ9S";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>