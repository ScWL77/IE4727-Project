<?php
// Include the database connection file
include 'dbconnect.php';

// Check if POST data is received
if (isset($_POST['movie']) && isset($_POST['outlet']) && isset($_POST['date'])) {
    // Retrieve and sanitize the POST data
    $movie = htmlspecialchars($_POST['movie']);
    $outlet = htmlspecialchars($_POST['outlet']);
    $dateString = htmlspecialchars($_POST['date']);

    // Convert the date string to the 'Y-m-d' format expected in the database
    $date = DateTime::createFromFormat('d M Y', $dateString);
    $formattedDate = $date ? $date->format('Y-m-d') : '';

    // Check if date conversion was successful
    if ($formattedDate) {
        // Prepare SQL query to get all start times for the given movie, date, and outlet
        $sql = "
            SELECT start_time 
            FROM showtimes 
            WHERE movie_id = ? 
            AND show_date = ? 
            AND outlet_id = (
                SELECT id FROM outlets WHERE name = ?
            )
        ";

        $stmt = $conn->prepare($sql);

        // Bind parameters (assuming $movie corresponds to a movie ID)
        $stmt->bind_param("iss", $movie, $formattedDate, $outlet);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any timeslots are found
        if ($result->num_rows > 0) {
            // Create a form for time slot selection
            echo '<form method="POST" action="get-seats.php">';
            echo '<input type="hidden" name="movieID" value="' . htmlspecialchars($movie) . '">';
            echo '<input type="hidden" name="date" value="' . htmlspecialchars($formattedDate) . '">';
            echo '<input type="hidden" name="venue" value="' . htmlspecialchars($outlet) . '">';

            // Loop through each timeslot and create a button for it
            while ($row = $result->fetch_assoc()) {
                $timeSlot = $row['start_time'];
                echo '<button type="submit" class="toggle-btn" name="time_slot" value="' . htmlspecialchars($timeSlot) . '">' . htmlspecialchars($timeSlot) . '</button>';
            }

            echo '</form>'; // Close the form
        } else {
            echo '<p>No available timeslots for this movie at the selected date and venue.</p>';
        }

        // Close the statement
        $stmt->close();
    } else {
        echo '<p>Invalid date format.</p>';
    }
} else {
    echo '<p>Required data not received. Please try again.</p>';
}

// Close the database connection
$conn->close();
?>
