<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Outlets Page</title>
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

// Fetch all outlets from the database
$query = "SELECT * FROM outlets";  // Adjust this query based on your database structure
$result = $conn->query($query);
?>

<div class="movie-card-container">
    <!-- Outlets Section -->
    <table border="0" class="payment-table">
        <thead>
            <tr>
                <th colspan="2">Our Outlets</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="outlet-row">
                    <?php
                    while ($outlet = $result->fetch_assoc()) {
                        $name = $outlet['name'];
                        $photo = $outlet['photo'];
                        $address = $outlet['address'];
                        $outlet_id = $outlet['id'];
                        ?>
                        <div class="outlet-card-link" id="no-underline">
                            <div class="outlet-card">
                                <div class="movie-details">
                                <img src="<?php echo $photo; ?>" alt="<?php echo $title; ?> Image" class="outlet-photo">
                                    <h3 class="movie-title"><?php echo $name; ?></h3>
                                    <p class="movie-info">Address: <?php echo $address; ?></p>
                                </div>
                            </div>
                    </div>

                        <?php
                    }
                    ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
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
