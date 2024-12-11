<?php
// Database connection details
$host = 'localhost';
$user = 'root';       
$password = '';      
$dbname = 'golden_gate_cinema';  

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>