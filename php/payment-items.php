<?php
// Include the database connection
include 'dbconnect.php'; // Adjust path as needed

// Hardcoded userID for testing
$userID = $_SESSION['userID'];
$_SESSION['bookings'] = []; // Initialize session array to store booking details

// Function to fetch cart data for a given user
function fetchCartData($conn, $userID) {
    $sql = "SELECT * FROM cart WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to fetch movie details by movieID
function fetchMovieDetails($conn, $movieID) {
    $movieSql = "SELECT title, poster FROM movies WHERE id = ?";
    $movieStmt = $conn->prepare($movieSql);
    $movieStmt->bind_param("i", $movieID);
    $movieStmt->execute();
    $movie = $movieStmt->get_result()->fetch_assoc();
    $movieStmt->close();
    return $movie;
}

// Function to adjust seat numbers
function adjustSeats($seatsSelected) {
    return implode(",", array_map(function($seatId) {
        $seatId = trim($seatId); // Trim to handle spaces
        $seatNumber = intval(substr($seatId, 1));
        $seatLetter = substr($seatId, 0, 1);
        return $seatNumber > 5 ? $seatLetter . ($seatNumber - 3) : $seatId;
    }, explode(',', $seatsSelected)));
}

// Function to calculate total display price
function calculateTotalPrice($price, $numberOfTickets) {
    return $price * $numberOfTickets;
}

// Fetch cart data for the specified userID
$result = fetchCartData($conn, $userID);
$totalPrice = 0;

while ($row = $result->fetch_assoc()):
    $movieID = $row['movieID'];
    $movie = fetchMovieDetails($conn, $movieID);

    $price = $row['total'];
    $numberOfTickets = $row['numberOfTickets'];
    $totalDisplay = calculateTotalPrice($price, $numberOfTickets);

    $adjustedSeats = adjustSeats($row['seatsSelected']);

    $_SESSION['bookings'][] = [
        'title' => $movie['title'],
        'outlet' => $row['outlet'],
        'date' => $row['date'],
        'time' => $row['time'],
        'seatsSelected' => $adjustedSeats,
        'total' => $price
    ];

    $totalPrice += $price;
    $_SESSION['totalPrice'] = number_format($totalPrice, 2);
endwhile;

// Close connection
$conn->close();
?>
