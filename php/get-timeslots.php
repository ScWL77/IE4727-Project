<?php
    
    //start session
    session_start();

    //Establish database connection
    include "dbconnect.php";

    // Check if POST data is received
    if (isset($_POST['movie']) && isset($_POST['outlet']) && isset($_POST['date'])) {
        // Retrieve and sanitize the POST data
        $movieTitle = htmlspecialchars($_POST['movie']);
        $outletName = htmlspecialchars($_POST['outlet']);
        $dateString = htmlspecialchars($_POST['date']);

        // Convert the date string to the 'Y-m-d' format expected in the database
        $date = DateTime::createFromFormat('d/m/Y', $dateString);
        $formattedDate = $date ? $date->format('Y-m-d') : '';

        // Check if date conversion was successful
        if ($formattedDate) {
            // Prepare SQL query to get all start times for the given movie, date, and outlet
            $sql = "
                SELECT showtimes.start_time 
                FROM showtimes
                JOIN movies ON showtimes.movie_id = movies.id
                JOIN outlets ON showtimes.outlet_id = outlets.id
                WHERE movies.title = ? 
                AND showtimes.show_date = ? 
                AND outlets.name = ? 
                ORDER BY showtimes.start_time
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $movieTitle, $formattedDate, $outletName);

            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();

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