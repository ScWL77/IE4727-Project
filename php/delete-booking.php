<?php
// Include the database connection
include 'dbconnect.php'; 


// Function to delete a booking from the cart
function deleteBooking($conn, $bookingID) {
    $sql = "DELETE FROM cart WHERE bookingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingID);

    // Execute the statement and return whether it was successful
    if ($stmt->execute()) {
        return true;
    } else {
        return $stmt->error;
    }
}


// Check if the booking ID is set in the URL
if (isset($_GET['id'])) {
    $bookingID = $_GET['id'];

    // Use the function to delete the booking
    $deleteResult = deleteBooking($conn, $bookingID);

    // Check the result of the deletion
    if ($deleteResult === true) {
        // Redirect back to the cart page with a success message
        header("Location: ../html/cart.php?msg=Booking deleted successfully.");
        exit();
    } else {
        // Display an error message if the deletion fails
        echo "Error deleting booking: " . $deleteResult;
    }
} else {
    // If no ID is provided, redirect back with an error message
    header("Location: ../html/cart.php?msg=No booking ID provided.");
    exit();
}

?>
