<?php
// Include the database connection file
include 'dbconnect.php';

// Check if the necessary cookies are set
if (isset($_SESSION['date']) && isset($_SESSION['outlet']) && isset($_SESSION['showtime']) && isset($_SESSION['movie'])) {
    // Retrieve other values from session
    $movieTitle = $_SESSION['movie'];
    $showDate = $_SESSION['date'];
    $outletName = $_SESSION['outlet'];
    $showtime = $_SESSION['showtime'];

    // Parse the date into an array
$date_parts = explode('/', $showDate); 

// Reformat the date to DD/MM/YYYY
if (count($date_parts) == 3) {
    $date = $date_parts[1] . '/' . $date_parts[0] . '/' . $date_parts[2];
}
    // Retrieve movie ID from the database using the movie title
    $sql = "SELECT id FROM movies WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $movieTitle); // 's' for string parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the movie ID
        $row = $result->fetch_assoc();
        $movieID = $row['id']; // Store the movie ID
    } else {
        // If no movie is found with the given title
        echo "<p>Movie not found in the database.</p>";
        return;
    }

    // Close the statement
    $stmt->close();

    // Now you can use $movieID in your seat selection logic
    $timeSlot = $showtime; // Use the showtime from the cookie

    // Convert the date format if needed
    $showDate = DateTime::createFromFormat('m/d/Y', $showDate)->format('Y-m-d');

    // Validate the time format (HH:MM:SS)
    if (DateTime::createFromFormat('H:i:s', $timeSlot) === false) {
        die('Invalid time format.');
    }

    $formattedTime = $timeSlot;

    // Prepare the SQL query to fetch seat information
    $sql = "SELECT seatsAvailable, seatsOccupied FROM seats WHERE movieID = ? AND showDate = ? AND showTime = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("iss", $movieID, $showDate, $formattedTime);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $availableSeats = [];
    $occupiedSeats = [];

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $availableSeats = array_map('trim', explode(',', $row['seatsAvailable']));
        $occupiedSeats = array_map('trim', explode(',', $row['seatsOccupied']));
    } else {
        echo "No matching records found for the provided movieID, date, and time.";
    }

    $stmt->close();
    $_SESSION['selected_time_slot'] = $formattedTime;

} else {
    // Handle case where cookies are not set
    echo "<br><br>Required information (movie, date, outlet, showtime) is missing. Please select a showtime.<br>";
    return; // Stop further processing
}
?>

<thead>
    <th colspan="17" style="background-color: #79747E; text-align: center; color:white;">screen</th>
</thead>
<tr style="height: 20px;"><td colspan="17"></td></tr> 
<tbody>
    <?php
    // Define the rows and other parameters
    $rows = ['A', 'B', 'C', 'D'];
    $seatsPerRow = 13; // Total number of seats in each row

    foreach ($rows as $row) {
        echo '<tr>';
        echo '<td><div class="space"></div></td>'; // Fixed space at the beginning of the row
        echo '<td id="wall-align-left">' . $row . '</td>'; // Row label
    
        // Loop through each seat in the current row
        for ($i = 1; $i <= $seatsPerRow; $i++) {
            $seatID = $row . $i; // Create seat ID (e.g., A1, A2, etc.)
    
            // Check if the current row is A, B, or C and the column is between 6 and 8
            if (in_array($row, ['A', 'B', 'C']) && $i >= 6 && $i <= 8) {
                echo '<td><div class="space"></div></td>'; // Fixed space for columns 6 to 8
            } elseif ($row === 'D' && ($i >= 6 && $i <= 8 || $i === 9 || $i === 11 || $i === 12)) {
                // Check if the current row is D and the column is 6-8, 9, 11-12
                echo '<td><div class="space"></div></td>'; // Fixed space for specified columns in row D
            } else {
                // Check if the seat is specifically D10 or D13 (for special conditions)
                if ($seatID === 'D10' || $seatID === 'D13') {
                    if (in_array($seatID, $occupiedSeats)) {
                        echo '<td><div class="clickable-square occupied"></div></td>'; // Occupied wheelchair seat
                    } elseif (in_array($seatID, $availableSeats)) {
                        echo '<td><div class="clickable-square wc wheelchair" data-seat-id="' . $seatID . '" onclick="toggleSeat(this)"></div></td>'; // Available wheelchair seat
                    } else{
                        echo '<td><div class="space"></div></td>';
                    }
                } else {
                    if (in_array($seatID, $occupiedSeats)) {
                        echo '<td><div class="clickable-square occupied"></div></td>'; // Occupied seat
                    } elseif (in_array($seatID, $availableSeats)) {
                        echo '<td><div class="clickable-square available" data-seat-id="' . $seatID . '" onclick="toggleSeat(this)"></div></td>'; // Available seat
                    } else {
                        echo '<td><div class="clickable-square selected"></div></td>'; // If you have any special status for seats
                    }
                }
            }
        }
    
        echo '<td id="wall">' . $row . '</td>'; // Fixed wall at the end of the row
        echo '<td><div class="space"></div></td>'; // Fixed space at the end of the row
        echo '</tr>';
    }

    ?>
</tbody>
<tr style="height: 20px;"><td colspan="17"></td></tr> 
