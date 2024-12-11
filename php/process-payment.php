<?php
session_start();
include 'dbconnect.php'; // Adjust path as necessary

// Function to generate a random transaction ID
function generateRandomTransactionID() {
    return random_int(100000, 999999); // Generate a random transaction ID
}

// Get the payment method from the form
$paymentMethod = $_POST['payment-method'];
$userID = $_SESSION['userID']; // Assuming userID is stored in the session

try {
    // Retrieve user's email address from the users table
    $emailSql = "SELECT email FROM users WHERE userID = ?";
    $emailStmt = $conn->prepare($emailSql);
    if (!$emailStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $emailStmt->bind_param("i", $userID);
    $emailStmt->execute();
    $emailResult = $emailStmt->get_result();

    if ($emailResult->num_rows === 0) {
        throw new Exception("User email not found.");
    }

    $userEmail = $emailResult->fetch_assoc()['email'];
    $emailStmt->close();

    $conn->begin_transaction(); // Start transaction

    //Check if cart has bookings that conflicts in terms of timing as well as bookings from past transactions
    // Get all bookings for the current user, including movie duration and check for clashes

    $clashStatus ="no_clash";
    $sql = "SELECT c.date, c.time, c.movieID, m.duration 
            FROM cart c 
            JOIN movies m ON c.movieID = m.id
            WHERE c.userID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store bookings in an array for comparison
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $startTime = strtotime($row['time']);
        $endTime = $startTime + ($row['duration'] * 60); // Convert duration from minutes to seconds
        $bookings[] = [
        'movieDate' => $row['date'],
        'startTime' => $startTime,
        'endTime' => $endTime,
        'movieID' => $row['movieID'],
        ];
    }

    // Check for clashes
    $clashes = [];
    $clashedMovieIDs = []; // Array to store movieIDs that are involved in clashes
    for ($i = 0; $i < count($bookings) - 1; $i++) {
        for ($j = $i + 1; $j < count($bookings); $j++) {
            // checks if the end time of the first booking occurs after the start time of the second booking and   (first booking still in progress when second starts)
            // if the start time of the first booking occurs before the end time of the second booking. (second booking start before the end of first booking)
            if ($bookings[$i]['movieDate'] === $bookings[$j]['movieDate'] && 
                $bookings[$i]['endTime'] > $bookings[$j]['startTime'] && 
                $bookings[$i]['startTime'] < $bookings[$j]['endTime']) {
                $clashes[] = "Clash between booking " . ($i + 1) . " and booking " . ($j + 1);
                // Store the movieIDs involved in the clash
                $clashedMovieIDs[] = $bookings[$i]['movieID']; // Assuming bookings array has movieID
                $clashedMovieIDs[] = $bookings[$j]['movieID'];
            }
        }
    }

    // Update clash status if clashes were found among bookings
    if (!empty($clashes)) {
        $clashStatus = 'booking_clash'; // Set status to booking_clash
    }

    // Check for clashes with past transactions
    foreach ($bookings as $booking) {
        // Updated SQL query to join transactions and movies based on userID and movieID
        $sqlPastTransactions = "SELECT t.movieDate, t.movieTime, m.duration 
                                FROM transactions t 
                                JOIN movies m ON t.movieID = m.id
                                WHERE t.userID = ? AND t.movieDate = ?";

        $stmtPast = $conn->prepare($sqlPastTransactions);
        $stmtPast->bind_param("is", $userID, $booking['movieDate']);
        $stmtPast->execute();
        $resultPast = $stmtPast->get_result();

        while ($pastRow = $resultPast->fetch_assoc()) {
            $pastStartTime = strtotime($pastRow['movieTime']);
            $pastEndTime = $pastStartTime + ($pastRow['duration'] * 60); // Convert duration from minutes to seconds
            // Check for clash with the current booking
            if ($booking['endTime'] > $pastStartTime && $booking['startTime'] < $pastEndTime) {
                $clashes[] = "Clash between current cart booking and past transaction for movieID " . $booking['movieID'];
                $clashedMovieIDs[] = $booking['movieID'];

                // Update clash status if a clash with past transactions is found
                $clashStatus = ($clashStatus === 'booking_clash') ? 'both' : 'past_clash'; // Set status accordingly
            }
        }
    }

    // Display clashes if any
    if ($clashStatus !== 'no_clash') {
        $_SESSION['clashedMovieIDs'] = array_unique($clashedMovieIDs);
        $_SESSION['clashes'] = $clashes; // Store clash messages in session
        print_r($clashedMovieIDs); // Debugging line
        header("Location: ../html/transaction-msg.php?status=" . $clashStatus); // Redirect with the clash status
        exit();
    }


    // Get the current timestamp and date
    $currentTime = date('Y-m-d H:i:s'); // Store current timestamp
    $currentDate = date('Y-m-d'); // Store current date

    // Use the stored values in your SQL query
    $transactionSql = "INSERT INTO transactions (transactionTime, transactionDate, status, paymentMethod, userID, movieID, outlet, movieTime, movieDate, movieSeats, subtotal)
                    SELECT ?, ?, 'Completed', ?, ?, movieID, outlet, time, date, GROUP_CONCAT(seatsSelected SEPARATOR ', '), 
                            (13 * SUM(LENGTH(seatsSelected) - LENGTH(REPLACE(seatsSelected, ',', '')) + 1)) AS subtotal
                    FROM cart 
                    WHERE userID = ? 
                    GROUP BY movieID, outlet, time, date";

    $stmt = $conn->prepare($transactionSql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("sssii", $currentTime, $currentDate, $paymentMethod, $userID, $userID);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create transaction: " . $stmt->error);
    }

    // Update the seats table here 
    // Fetch the current movie IDs, dates, times, and venues from the cart for updating seats
    
    $cartSql = "SELECT cart.movieID, cart.date, cart.time, outlets.id, outlets.name, 
                GROUP_CONCAT(cart.seatsSelected SEPARATOR ', ') AS seatsSelected 
                FROM cart 
                JOIN outlets ON cart.outlet = outlets.name
                WHERE cart.userID = ? 
                GROUP BY cart.movieID, cart.date, cart.time, outlets.id";

    $cartStmt = $conn->prepare($cartSql);
    $cartStmt->bind_param("i", $userID);
    $cartStmt->execute();
    $cartResult = $cartStmt->get_result();

    // Loop through the cart items to update the seats table
    while ($cartRow = $cartResult->fetch_assoc()) {
        $movieID = $cartRow['movieID'];
        $movie_date = $cartRow['date'];
        $movie_time = $cartRow['time'];
        $venue = $cartRow['name'];
        $venueID = $cartRow['id'];    // Outlet ID
        $seats_selected = $cartRow['seatsSelected'];
        $seats_array = explode(", ", $seats_selected); // Convert selected seats to an array

        // Step 1: Get the current seats information
        $sql_seats = "SELECT seatsAvailable, seatsOccupied FROM seats WHERE movieID = ? AND showDate = ? AND showTime = ? AND movieOutlet = ?";
        $stmt_seats = $conn->prepare($sql_seats);
        $stmt_seats->bind_param("isss", $movieID, $movie_date, $movie_time, $venueID);
        $stmt_seats->execute();
        $stmt_seats->bind_result($seatsAvailable, $seatsOccupied);
        $stmt_seats->fetch();
        $stmt_seats->close();

        // Step 2: Update occupied seats
        $newOccupiedSeats = array_merge(explode(',', $seatsOccupied), $seats_array);
        $updatedOccupied = implode(',', array_map('trim', $newOccupiedSeats)); // Trim spaces

        // Update available seats
        $availableSeatsArray = explode(',', $seatsAvailable);
        $occupiedSeatsArray = array_map('trim', $seats_array); // Ensure the selected seats are trimmed

        // Calculate the updated available seats
        $updatedAvailableSeats = array_diff($availableSeatsArray, $occupiedSeatsArray);

        // Trim whitespace and convert back to a comma-separated string
        $updatedAvailable = implode(',', array_map('trim', $updatedAvailableSeats));

        // Step 3: Perform the update
        $sql_update_seats = "UPDATE seats SET seatsOccupied = ?, seatsAvailable = ? WHERE movieID = ? AND showDate = ? AND showTime = ? AND movieOutlet = ?";
        $stmt_update_seats = $conn->prepare($sql_update_seats);
        $stmt_update_seats->bind_param("ssisss", $updatedOccupied, $updatedAvailable, $movieID, $movie_date, $movie_time, $venueID);

        // Execute the update and check for errors
        if (!$stmt_update_seats->execute()) {
            throw new Exception("Error updating seats: " . $stmt_update_seats->error);
        }
        $stmt_update_seats->close();
    }
    $cartStmt->close();

    // Fetch existing transactions with the same time and date
    $summarySql = "SELECT t.transactionID, 
                      m.title AS movieTitle, 
                      t.movieSeats, 
                      t.movieDate, 
                      t.movieTime, 
                      t.outlet, 
                      t.subtotal
               FROM transactions t
               JOIN movies m ON t.movieID = id
               WHERE t.userID = ? AND t.transactionTime = ? AND t.transactionDate = ?
               ORDER BY t.movieDate ASC"; 

    $summaryStmt = $conn->prepare($summarySql);
    if (!$summaryStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $summaryStmt->bind_param("iss", $userID, $currentTime, $currentDate);
    $summaryStmt->execute();
    $summaryResult = $summaryStmt->get_result();

    // Generate a random transaction ID
    $newTransactionID = generateRandomTransactionID();

    // Initialize summary details
    $transactionDetails = "";
    $totalAmount = 0;

    // Loop through existing transactions and build summary
    while ($summaryRow = $summaryResult->fetch_assoc()) {
        // Get the movie title and other details
        $movieTitle = $summaryRow['movieTitle'];
        $outlet = $summaryRow['outlet'];
        $movieTime = $summaryRow['movieTime'];
        $movieDate = $summaryRow['movieDate'];
        
        // Get the seats and format them as a list with adjustments
        $seatsSelected = explode(',', $summaryRow['movieSeats']); // Convert to array
        $adjustedSeats = implode(",", array_map(function($seatId) {
            // Trim the seat ID to remove any extra whitespace
            $seatId = trim($seatId); // Trim to handle spaces
            
            // Extract the letter and number parts of the seat
            $seatNumber = intval(substr($seatId, 1)); // Get the numeric part of the seat
            $seatLetter = substr($seatId, 0, 1); // Get the letter part of the seat
            
            // Subtract 3 from the seat number if it's greater than 5
            return $seatNumber > 5 ? $seatLetter . ($seatNumber - 3) : $seatId; 
        }, $seatsSelected)); // Format seats as a list

        // Count the number of tickets
        $numberOfTickets = count($seatsSelected);

        // Append transaction details
        $transactionDetails .= "
        Movie Title: $movieTitle
        Outlet: $outlet
        Movie Time: $movieTime
        Movie Date: $movieDate
        Seats: $adjustedSeats
        Number of Tickets: $numberOfTickets";

        // Update the total amount
        $totalAmount += $summaryRow['subtotal'];
    }    

    // Clear the cart after successful transaction
    $clearCartSql = "DELETE FROM cart WHERE userID = ?";
    $clearCartStmt = $conn->prepare($clearCartSql);
    if (!$clearCartStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $clearCartStmt->bind_param("i", $userID);
    $clearCartStmt->execute();

    $conn->commit(); // Commit the transaction

    // Update the seats table here 
    // Prepare email
    $to = $userEmail;
    $subject = "Transaction Confirmation - ID: " . $newTransactionID;

    $message = "Thank you for your purchase!\n\n" .
            "Transaction Details:\n";

    $message .= $transactionDetails; // Add the formatted transaction details

    $message .= "\n\n" . "Total Amount: $" . number_format($totalAmount, 2) . "\n\n" .
                "Paymemt Method: " . $paymentMethod . "\n\n" .
                "We hope you enjoy your movie and please present this email at the counter on the day of your visit to exchange it for your tickets.";

    // Headers
    $headers = 'From: root@localhost' . "\r\n" .
            'Reply-To: root@localhost' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();


    // Send email
    if (!mail($to, $subject, $message, $headers, '-froot@localhost')) {
        throw new Exception("Failed to send email.");
    }

    header("Location: ../html/transaction-msg.php?status=success");
    exit();

} catch (Exception $e) {
    $conn->rollback(); // Rollback the transaction on error
    // Redirect to the transaction page with error message
    header("Location: ../html/transaction-msg.php?status=error&message=" . urlencode($e->getMessage()));
    exit();
} finally {
    // Clean up resources
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($summaryStmt)) {
        $summaryStmt->close();
    }
    if (isset($clearCartStmt)) {
        $clearCartStmt->close();
    }
    $conn->close();
}
?>
