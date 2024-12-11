<?php
// Include the database connection
include 'dbconnect.php'; // Adjust the path as needed
session_start();

// Function to check if the username or email already exists in the database
function isUserExists($conn, $username, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;  // Returns true if user exists, false otherwise
}

// Function to hash the password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);  // Hashes the password
}

// Function to insert a new user into the database
function insertUser($conn, $username, $contact, $email, $password) {
    $stmt = $conn->prepare("INSERT INTO users (username, contact, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $contact, $email, $password);
    return $stmt->execute();  // Returns true if insertion is successful
}

// Function to redirect with an error message
function redirectWithError($url, $error,$form) {
    header("Location: $url?error=$error&form=$form");
    exit();
}

// Function to redirect to the homepage after a successful signup
function redirectToHome() {
    header('Location: ../html/cart.php');  // Adjust the path as needed
    exit();
}

// Main script starts here
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = hashPassword($_POST['password']); // Hash the password

    // Check for existing username or email
    if (isUserExists($conn, $username, $email)) {
        redirectWithError('../html/login-register.php', 'username_or_email_exists','signup');

    } else {
        // Insert the new user into the database
        if (insertUser($conn, $username, $contact, $email, $password)) {
            // Redirect to the homepage upon successful signup
            $userID = $conn->insert_id;
            $_SESSION['userID'] = $userID;
            redirectToHome();
        } else {
            redirectWithError('../html/login-register.php', 'database_error', 'signup');
        }
    }
}
?>
