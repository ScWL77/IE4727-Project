<?php
session_start(); // Start the session to use session variables

include "dbconnect.php"; // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve values from cookies instead of hardcoding them
    //Check if user_id exists in the session
if (!isset($_SESSION['userID'])) {
    // Save the current URL (add_to_cart.php) in the session to redirect after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];  // This will save the current page URL
    
    // Redirect the user to the login page
    header("Location: ../html/login-register.php");
    exit();
}
    $user_id = $_SESSION['userID']; 
    $movie_date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';

    $movie_date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';

// Check if the date is in the format DD/MM/YYYY
if ($movie_date) {
    try {
        // Create a DateTime object from the given date format (DD/MM/YYYY)
        $date = DateTime::createFromFormat('d/m/Y', $movie_date); // Specify the format
        if ($date) {
            // Convert the date into 'Y-m-d' format (MySQL compatible format)
            $movie_date = $date->format('Y-m-d');
        } else {
            // Handle invalid date format
            throw new Exception("Invalid date format.");
        }
    } catch (Exception $e) {
        // Log or handle error (optional)
        error_log("Error: " . $e->getMessage());
        $movie_date = null; // Set to null or handle as needed
    }
}

// Now $movie_date is in the 'YYYY-MM-DD' format and can be saved in the MySQL table


    $venue = isset($_SESSION['outlet']) ? $_SESSION['outlet'] : "Golden Gate Cinema Bishan"; // Use cookie or fallback
    $title = isset($_SESSION['movie']) ? $_SESSION['movie'] : "Despicable Me 4"; // Use cookie or fallback
    $movie_time = $_POST['selected_time_slot']; // Movie time sent from the form
    $seats_selected = $_POST['hidden-selected-seats']; // Retrieve selected seats
    $total = $_POST['hidden-total']; // Total amount calculated on the client side
    $total = number_format((float)$total, 2, '.', ''); 
    $seats_array = explode(", ", $seats_selected); 
    $num_tickets = count($seats_array); // Count of selected seats

    // Step 1: Get the movieID from the movies table
    function getMovieID($conn, $title) {
        $sql_movie = "SELECT id FROM movies WHERE title = ?";
        $stmt_movie = $conn->prepare($sql_movie);
        $stmt_movie->bind_param("s", $title);
        $stmt_movie->execute();
        $stmt_movie->bind_result($movieID);
        $stmt_movie->fetch();
        $stmt_movie->close();
        return $movieID;
    }

    // Step 2: Insert the details into the cart table
    function insertCart($conn, $user_id, $movieID, $seats_selected, $venue, $movie_date, $movie_time, $total, $num_tickets) {
        $sql_cart = "INSERT INTO cart (userID, movieID, seatsSelected, outlet, date, time, total, numberOfTickets)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param("iissssdi", $user_id, $movieID, $seats_selected, $venue, $movie_date, $movie_time, $total, $num_tickets);
        
        if ($stmt_cart->execute()) {
            return true;
        } else {
            return $stmt_cart->error;
        }
    }

    // Retrieve movieID
    $movieID = getMovieID($conn, $title);
    
    // Check if movieID was found
    if (!$movieID) {
        die("Movie not found.");
    }

     // Insert details into the cart
    $insertResult = insertCart($conn, $user_id, $movieID, $seats_selected, $venue, $movie_date, $movie_time, $total, $num_tickets);

    if ($insertResult === true) {
        echo "Seats successfully added to the cart.";
        header("Location: ../html/cart.php");
        exit();
    } else {
        echo "Error adding seats to the cart: " . $insertResult;
    }

    $conn->close();

} else {
    // Handle the case where the form was not submitted properly
    echo "No data submitted.";
}
?>