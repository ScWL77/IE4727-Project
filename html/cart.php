<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cart Page</title>
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
                <span style="font-size: 30px; font-weight: bold;">Cart</span>
                <form action="" method="">
                    <table border="0" class="cart-table">
                        <thead>
                            <tr>
                                <th>Poster</th>
                                <th>Title</th>
                                <th>Date and Venue</th>
                                <th>Venue</th>
                                <th>Price (Quantity) </th>
                                <th>Seats selected</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../php/fetch-cart.php'; ?>
                        </tbody>
                        <tfoot>
                            <td colspan="5">Total Price: </td>
                            <td colspan="2">$<span id="total-price-display"></span></td>
                        </tfoot>
                    </table>
                    <div class="button-container">
                        <button type="button" id="checkout-button" onclick="goToNextPage()">Checkout Bookings</button>
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
        <script>
            // Display total price from hidden input field
            document.addEventListener("DOMContentLoaded", function() {
                const totalPrice = document.getElementById("total-price").value;
                document.getElementById("total-price-display").textContent = totalPrice;
            });
        </script>
        <script>
            function goToNextPage() {
                window.location.href = "payment.php"; 
            }
        </script>
    </body>
</html>
