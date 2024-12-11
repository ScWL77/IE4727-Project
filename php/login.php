

<?php
// Include the database connection
session_start();
include 'dbconnect.php'; // Adjust the path as needed


//Check if there's a redirect destination
if (isset($_SESSION['redirect_after_login'])) {
    $redirect_url = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']); // Clear the redirect session variable
} else {
    $redirect_url = "../html/home.php"; // Default redirect page
}

$errorMessage = '';

// Function to validate user login
function validateUserLogin($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // Username does not exist
        return 'account_not_found';
    } else {
        // Username exists, check the password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['userID'] = $user['userID'];
            return 'login_success';
        } else {
            // Incorrect password
            return 'incorrect_password';
        }
    }
}

// Function to redirect with error
function redirectWithError($error, $form) {
    header("Location: ../html/login-register.php?error=$error&form=$form");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain-text password

    // Validate user login
    $loginStatus = validateUserLogin($conn, $username, $password);

    // Redirect based on login status
    if ($loginStatus == 'login_success') {
        // Redirect to the homepage upon successful login
        header('Location: ../html/cart.php'); // Adjust the path as needed
        exit();
    } else {
        // Redirect with an error
        redirectWithError($loginStatus, 'login');
    }
}
?>
