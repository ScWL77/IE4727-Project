<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Showtime Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body>
        <header>
            <img class="logo" src="../assets/GGC.png" alt="logo">
            <nav>
            <ul class="nav_links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="showtimes.php">Showtimes</a></li>
                    <li><a href="outlets.php">Cinemas</a></li>
                </ul>
            </nav>
            <div class="logo-right">
                <a class="cart" id="cart" href="cart.php"><img class="side-logo" src="../assets/cart-logo.png" alt="cart-logo"></a>
                <?php if (isset($_SESSION['userID'])): ?>
                    <!-- If user is logged in, show the Logout link -->
                    <a class="logout" id="logout" href="../php/logout.php"><img class="logout-logo" src="../assets/logout-logo.png" alt="logout-logo"></a>
                <?php else: ?>
                    <!-- If user is not logged in, show the Login/Signup links -->
                    <a class="user" id="user" href="login-register.php"><img class="side-logo" src="../assets/user-logo.png" alt="user-logo"></a>
                <?php endif; ?>
            </div>
        </header>

<?php
// Database connection (adjust with your database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "golden_gate_cinema";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<div class="movie-card-container">
    <!-- Now Showing Section -->
    <table border="0" class="payment-table" id="showtimes-table">
        <thead>
            <tr>
                <th colspan="4">Movie Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <form method="GET">
                <td style="width: 33.33%; padding: 10px; box-sizing: border-box;">
    <!-- Date Filter -->
    <select name="date" id="filter-dropdown">
        <option value="">Select Date</option>
        <?php
        $date_result = $conn->query("SELECT DISTINCT DATE(show_date) AS date FROM showtimes ORDER BY date");
        while ($date = $date_result->fetch_assoc()) {
            $selected = ($_GET['date'] == $date['date']) ? 'selected' : '';
            echo "<option value='" . $date['date'] . "' $selected>" . $date['date'] . "</option>";
        }
        ?>
    </select>
</td>

<td style="width: 33.33%; padding: 10px; box-sizing: border-box;">
    <!-- Outlet Filter -->
    <select name="outlet" id="filter-dropdown">
        <option value="">Select Outlet</option>
        <?php
        $outlet_result = $conn->query("SELECT id, name FROM outlets ORDER BY name");
        while ($outlet = $outlet_result->fetch_assoc()) {
            $selected = ($_GET['outlet'] == $outlet['id']) ? 'selected' : '';
            echo "<option value='" . $outlet['id'] . "' $selected>" . $outlet['name'] . "</option>";
        }
        ?>
    </select>
</td>

<td style="width: 33.33%; padding: 10px; box-sizing: border-box;">
    <!-- Movie Filter -->
    <select name="movie" id="filter-dropdown">
    <option value="">Select Movie</option>
    <?php
    // Get the list of movies from the database
    $movie_result = $conn->query("SELECT id, title FROM movies ORDER BY title");

    // Loop through the movies and generate the options
    while ($movie = $movie_result->fetch_assoc()) {
        // Check if this movie is the one selected via the URL
        $selected = (isset($_GET['movie']) && $_GET['movie'] == $movie['id']) ? 'selected' : '';
        echo "<option value='" . $movie['id'] . "' $selected>" . $movie['title'] . "</option>";
    }
    ?>
</select>
</td>

                        <td style="padding: 10px;">
                            <button type="submit" class="unique-showtime-button">Filter</button>
                        </td>
                </form>
            </tr>
        </tbody>
    </table>

    <!-- Movie Slots Display Section -->
    <div class="showtimes-display">
        <?php
        // Base query to join tables
        $query = "SELECT 
            movies.id AS movie_id,
            movies.title AS movie_title, 
            movies.poster AS movie_poster, 
            movies.classification AS movie_classification, 
            movies.duration AS movie_duration, 
            movies.genre AS movie_genre,
            outlets.name AS outlet_name,
            showtimes.show_date AS show_date,
            showtimes.start_time AS showtime
            FROM showtimes
            JOIN movies ON showtimes.movie_id = movies.id
            JOIN outlets ON showtimes.outlet_id = outlets.id";

        // Apply filters based on selected dropdown options
        $filters = [];
        if (!empty($_GET['date'])) {
            $filters[] = "DATE(showtimes.show_date) = '" . $conn->real_escape_string($_GET['date']) . "'";
        }
        if (!empty($_GET['outlet'])) {
            $filters[] = "showtimes.outlet_id = '" . $conn->real_escape_string($_GET['outlet']) . "'";
        }
        if (!empty($_GET['movie'])) {
            $filters[] = "showtimes.movie_id = '" . $conn->real_escape_string($_GET['movie']) . "'";
        }

        // Append filters if any are set
        if (count($filters) > 0) {
            $query .= " WHERE " . implode(" AND ", $filters);
        }

        // Add the ORDER BY clause
        $query .= " ORDER BY showtimes.show_date, outlets.name, showtimes.start_time;";

        // Execute the query
        $showtime_result = $conn->query($query);

        // Initialize an array to hold the grouped data
        $movies = [];

        // Populate the array with showtimes
        while ($row = $showtime_result->fetch_assoc()) {
            $movie_id = $row['movie_id'];
            $show_date = $row['show_date'];
            $outlet_name = $row['outlet_name'];
            
            // Group by movie, then by date, then by outlet
            $movies[$movie_id]['details'] = [
                'title' => $row['movie_title'],
                'poster' => $row['movie_poster'],
                'classification' => $row['movie_classification'],
                'duration' => $row['movie_duration'],
                'genre' => $row['movie_genre']
            ];
            $movies[$movie_id]['showtimes'][$show_date][$outlet_name][] = $row['showtime'];
        }
        
        foreach ($movies as $movie) {
            echo "<div class='unique-movie-card'>";
        
            // Left container for movie details
            echo "<div class='unique-left-container'>";
            echo "<img src='" . htmlspecialchars($movie['details']['poster']) . "' alt='" . htmlspecialchars($movie['details']['title']) . " Poster' class='unique-movie-poster'>";
            echo "<div class='unique-description'>";
            echo "<h3>" . htmlspecialchars($movie['details']['title']) . "</h3>";
            echo "<p>Genre: " . htmlspecialchars($movie['details']['genre']) . "</p>";
            echo '<p><a  id="no-underline" href="' . htmlspecialchars($movie['details']['classification']) . '" target="_blank"><img src="' . htmlspecialchars($movie['details']['classification']) . '" alt="Classification Image" style="width: 50px; height: auto; margin-left: -10px"></a></p>';
            echo "<p>Duration: " . htmlspecialchars($movie['details']['duration']) . " mins</p>";
            echo "</div></div>"; // Close unique-left-container
        
            // Right container for showtimes
            echo "<div class='unique-right-container'>";
        
            foreach ($movie['showtimes'] as $show_date => $outlets) {
                echo "<h4>Show Date: " . date("d/m/Y", strtotime($show_date)) . "</h4>";
        
                foreach ($outlets as $outlet_name => $showtimes) {
                    echo "<h5>" . htmlspecialchars($outlet_name) . "</h5>";
                    echo "<div class='unique-timeslot-row'>";
                    
                    // For each showtime, create a form with hidden inputs
                    foreach ($showtimes as $time) {
                        echo "<form action='seats-selection.php' method='POST'>
                                <!-- Hidden inputs for passing movie title, date, outlet, and showtime -->
                                <input type='hidden' name='movie' value='" . htmlspecialchars($movie['details']['title']) . "'>
                                <input type='hidden' name='date' value='" . date("d/m/Y", strtotime($show_date)) . "'>
                                <input type='hidden' name='outlet' value='" . htmlspecialchars($outlet_name) . "'>
                                <input type='hidden' name='showtime' value='" . htmlspecialchars($time) . "'>
                                
                                <!-- Showtime button that will submit the form -->
                                <button class='unique-showtime-button' type='submit'>" . htmlspecialchars($time) . "</button>
                              </form> ";
                    }
                    echo "</div>"; // Close unique-timeslot-row
                }
            }
        
            echo "</div>"; // Close unique-right-container
            echo "</div>"; // Close unique-movie-card
        }        
?>
    </div>
</div>

<footer>
            <div class="row">
                <div class="col">
                    <img src="../assets/GGC_white.png" class="footer-logo">
                    <p>Golden Gate Cinema is a premier entertainment destination that offers a captivating movie-going experience with a blend of luxury, comfort, and the latest in cinematic technology.</p>
                </div>
                <div class="col">
                    <h3 class="subheading1">Supported Payments</h3>
                    <img src="../assets/visa.png" class="payment-logo">
                    <img src="../assets/paylah.png" class="payment-logo">
                    <img src="../assets/paynow.png" class="payment-logo-paynow">

                    <h3 class="subheading2">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="home.php">Movies</a></li>
                        <li><a href="showtimes.php">Showtimes</a></li>
                        <li><a href="outlets.php">Cinemas</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h3 class="subheading3">Connect with Us</h3>
                    <img src="../assets/facebook.png" class="social-media-logo">
                    <img src="../assets/twitter.png" class="social-media-logo">
                    <img src="../assets/youtube.png" class="social-media-logo">
                    <img src="../assets/instagram.png" class="social-media-logo">
                    <img src="../assets/tiktok.png" class="social-media-logo">

                    <h3 class="subheading4">Get GCC Mobile App</h3>
                    <img src="../assets/appstore.png" class="download-logo">
                    <img src="../assets/playstore.png" class="download-logo-playstore">
                    <img src="../assets/appgallery.png" class="download-logo">
                </div>
            </div>
            <hr>
            <p class="copyright">&copy;Copyright 2024 Golden Gate Cinema. All Rights Reserved</p>
        </footer>
    </body>
</html>

<?php

// Close the database connection
$conn->close();
?>
