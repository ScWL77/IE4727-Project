
<?php
    session_start();
    include '../php/payment-items.php'; // Adjust the path as necessary
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Payment and Confirmation Page</title>
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
                <a class="cart" href="cart.php"><img class="side-logo" src="../assets/cart-logo.png" alt="cart-logo"></a>
                <?php if (isset($_SESSION['userID'])): ?>
                    <!-- If user is logged in, show the Logout link -->
                    <a class="logout" id="logout" href="../php/logout.php"><img class="logout-logo" src="../assets/logout-logo.png" alt="logout-logo"></a>
                <?php else: ?>
                    <!-- If user is not logged in, show the Login/Signup links -->
                    <a class="user" id="user" href="login-register.php"><img class="side-logo" src="../assets/user-logo.png" alt="user-logo"></a>
                <?php endif; ?>
            </div>
        </header>
        <div class="container">
            <div class="cart-box">
                <table border="0" class="payment-table">
                    <thead>
                        <th colspan="2">Booking Summary</th>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['bookings']  as $index => $booking): ?>
                            <tr>
                                <td>Movie Title:</td>
                                <td><?= htmlspecialchars($booking['title']); ?></td>
                            </tr>
                            <tr>
                                <td>Outlet:</td>
                                <td><?= htmlspecialchars($booking['outlet']); ?></td>
                            </tr>
                            <tr>
                                <td>Date & Time:</td>
                                <td><?= htmlspecialchars($booking['date']); ?>, <?= htmlspecialchars($booking['time']); ?></td>
                            </tr>
                            <tr>
                                <td>Seats:</td>
                                <td><?= htmlspecialchars($booking['seatsSelected']); ?></td>
                            </tr>
                            <tr>
                                <td>Total ($13 per ticket):</td>
                                <td>$<?= htmlspecialchars($booking['total']); ?></td>
                            </tr>
                            <?php if ($index < count($_SESSION['bookings']) - 1): ?> <!-- Add line for all except the last entry -->
                            <tr>
                                <td colspan="2" style="border-top: 1px solid black;"></td> <!-- Horizontal line -->
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Subtotal (GST Included):</td>
                            <td>$<?= htmlspecialchars($_SESSION['totalPrice']); ?></td>
                        </tr>
                    </tfoot>
                </table>
                <form action="../php/process-payment.php" method="POST">
                    <table border="0" class="payment-table" style="margin-top:25px;">
                        <thead>
                            <th>Payment Method</th>
                        </thead>
                        <tbody>
                            <td class="payment-options">
                                <input type="radio" id="visa" name="payment-method" value="VISA">
                                <label for="visa"><img src="../assets/visa.png" class="payment-logo"/></label>
                                <input type="radio" id="paylah" name="payment-method" value="Paylah">
                                <label for="paylah"><img src="../assets/paylah.png" class="payment-logo"/></label>
                                <input type="radio" id="paynow" name="payment-method" value="Paynow">
                                <label for="paynow"><img src="../assets/paynow.png" class="payment-logo-paynow"/></label>
                            </td>
                        </tbody>
                    </table>
                    <div class="button-container">
                        <button type="submit" value="Submit" id="payment-button">Proceed to Payment</button>
                    </div>
                </form>
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
