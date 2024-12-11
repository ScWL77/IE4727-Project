<?php 
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body>
        <main>
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

        // Fetch all movies from the database
        $query = "SELECT * FROM movies";  // Adjust this query based on your database structure
        $result = $conn->query($query);
        ?>

<div class="movie-card-container" >
    <!-- Now Showing Section -->
    <table border="0" class="payment-table">
        <thead>
            <tr>
                <th colspan="2">Now Showing</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="movie-row">
                    <?php
                    while ($movie = $result->fetch_assoc()) {
                        if ($movie['show_status'] === 'airing') { // Filter by category
                            $title = $movie['title'];
                            $poster = $movie['poster'];
                            $rating_icon = $movie['classification'];
                            $duration = $movie['duration'];
                            $movie_id = $movie['id'];
                            ?>
                            <a href="movie-description.php?id=<?php echo $movie_id; ?>" class="movie-card-link" id="no-underline">
                                <div class="movie-card">
                                    <img src="<?php echo $poster; ?>" alt="<?php echo $title; ?> Poster" class="movie-poster">
                                    <div class="movie-details">
                                        <h3 class="movie-title"><?php echo $title; ?></h3>
                                        <img src="<?php echo $rating_icon; ?>" alt="Rating" class="rating-icon">
                                        <p class="movie-info"><?php echo $duration; ?> minutes</p>
                                    </div>
                                </div>
                            </a>

                            <?php
                        }
                    }
                    $result->data_seek(0); 
                    ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Advance Sales Section -->
    <table border="0" class="payment-table">
        <thead>
            <tr>
                <th colspan="2">Advance Sales</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="movie-row">
                    <?php
                    while ($movie = $result->fetch_assoc()) {
                        if ($movie['show_status'] === 'advance sales') { // Filter by category
                            $title = $movie['title'];
                            $poster = $movie['poster'];
                            $rating_icon = $movie['classification'];
                            $duration = $movie['duration'];
                            $movie_id = $movie['id'];
                            ?>
                            <a href="movie-description.php?id=<?php echo $movie_id; ?>" class="movie-card-link" id="no-underline">
                                <div class="movie-card">
                                    <img src="<?php echo $poster; ?>" alt="<?php echo $title; ?> Poster" class="movie-poster">
                                    <div class="movie-details">
                                        <h3 class="movie-title"><?php echo $title; ?></h3>
                                        <img src="<?php echo $rating_icon; ?>" alt="Rating" class="rating-icon">
                                        <p class="movie-info">Duration: <?php echo $duration; ?> minutes</p>
                                    </div>
                                </div>
                            </a>

                            <?php
                        }
                    }
                    $result->data_seek(0); 
                    ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Coming Soon Section -->
    <table border="0" class="payment-table">
        <thead>
            <tr>
                <th colspan="2">Coming Soon</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="movie-row">
                    <?php
                    while ($movie = $result->fetch_assoc()) {
                        if ($movie['show_status'] === 'coming soon') { // Filter by category
                            $title = $movie['title'];
                            $poster = $movie['poster'];
                            $rating_icon = $movie['classification'];
                            $duration = $movie['duration'];
                            $movie_id = $movie['id'];
                            ?>
                            <a href="movie-description.php?id=<?php echo $movie_id; ?>" class="movie-card-link" id="no-underline">
                                <div class="movie-card">
                                    <img src="<?php echo $poster; ?>" alt="<?php echo $title; ?> Poster" class="movie-poster">
                                    <div class="movie-details">
                                        <h3 class="movie-title"><?php echo $title; ?></h3>
                                        <img src="<?php echo $rating_icon; ?>" alt="Rating" class="rating-icon">
                                        <p class="movie-info">Duration: <?php echo $duration; ?> minutes</p>
                                    </div>
                                </div>
                            </a>

                            <?php
                        }
                    }
                    ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</main>
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
