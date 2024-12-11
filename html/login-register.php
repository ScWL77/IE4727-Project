<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login/Signup Page</title>
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
        <div class="container-form">
            <div class="form-box">
                <div class="button-box">
                <div id="btn"></div>
                    <button type="button" class="toggle-btn" onclick="login()">Login</button>
                    <button type="button" class="toggle-btn" onclick="signup()">Signup</button>
                </div>
                <form id="login" class="input-group1" method="POST" action="../php/login.php">
                    <b id="form-title">Log into your account</b>
                    <input type="text" class="input-field" placeholder="Username" id="login_username" name="username" required>
                    <input type="password" class="input-field" placeholder="Password" id="login_password" name="password" required>
                    <span class="error-message">
                        <?php
                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == 'account_not_found') {
                                    echo "This account do not exist, please create an account.";
                                } elseif ($_GET['error'] == 'incorrect_password') {
                                    echo "You have provided an incorrect password, please try again.";
                                }
                            }
                        ?>
                    </span>
                    <button type="submit" class="submit-btn">Login</button>
                </form>
                <form id="signup" class="input-group2" method="POST" action="../php/signup.php">
                    <b id="form-title">Create an account</b>
                    <input type="text" class="input-field" placeholder="Username" id="signup_username" name="username" required>
                    <span id="username_error" class="error-message"></span>
                    <input type="text" class="input-field" placeholder="Contact Number" id="signup_contact" name="contact" required>
                    <span id="contact_error" class="error-message"></span>
                    <input type="text" class="input-field" placeholder="Email" id="signup_email" name="email" required>
                    <span id="email_error" class="error-message"></span>
                    <input type="password" class="input-field" placeholder="Password" id="signup_password" name="password" required>
                    <span id="password_error" class="error-message"></span>
                    <span class="error-message">
                        <?php
                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == 'username_or_email_exists') {
                                    echo "Username or email already exists. Please choose another.";
                                } elseif ($_GET['error'] == 'database_error') {
                                    echo "There was an error creating your account. Please try again.";
                                }
                            }
                        ?>
                    </span>
                    <button type="submit" class="submit-btn">Signup</button>
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
        <script type="text/javascript" src="../scripts/login-register.js"></script>
        <script>
            // Check URL for 'form' parameter
            const urlParams = new URLSearchParams(window.location.search);
            const form = urlParams.get('form');

            if (form === 'signup') {
                signup(); // Call the signup function to show the signup form
            } else {
                login(); // Call the login function to show the login form
            }
    </script>
    </body>
</html>
