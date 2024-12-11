<?php

session_start();

// Retrieve values sent via POST
$movie = isset($_POST['movie']) ? htmlspecialchars($_POST['movie']) : '';
$outlet = isset($_POST['outlet']) ? htmlspecialchars($_POST['outlet']) : '';
$date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';
$showtime = isset($_POST['showtime']) ? htmlspecialchars($_POST['showtime']) : '';

// Parse the date into an array
$date_parts = explode('/', $date); 

// Reformat the date to DD/MM/YYYY
if (count($date_parts) == 3) {
    $date = $date_parts[1] . '/' . $date_parts[0] . '/' . $date_parts[2];
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['movie']=$movie;
    $_SESSION['date']=$date;
    $_SESSION['outlet']=$outlet;
    $_SESSION['showtime']=$showtime;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Seats Selection Page</title>
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
            <div class="flex-container" style="display: flex; align-items: center;">
                    <div class="date-display" style="width: 120px;"><?php echo date("d M Y", strtotime($date)); ?></div>
                    <div class="venue-display" style="margin-left: 50px; width: 200px;">
                        <?php echo $outlet; ?>
                    </div>
                    <div class="venue-display" style="margin-left: 50px; width: 200px;">
                        <?php echo $showtime; ?>
                    </div>
                </div>               
                <br><br>
                <span style="font-size: 30px; font-weight: bold;"><?php echo isset($_POST['movie']) ? htmlspecialchars($_POST['movie']) : 'Unknown Movie'; ?></span>
                <form action="" method="POST" id="">
                    <div class="button-container-seats">
                    <?php include "../php/get-timeslots.php"?>
                    </div>
                </form>
                <table border="0" class="seats-table">
                    <?php include "../php/get-seats.php" ?>
                    <tfoot>
                        <tr style="height: 10px; background-color: #79747E;"><td colspan="17"></td></tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 100px;">LEGEND</td>
                            <td colspan="3" style="text-align: center;  padding-left: 12px;">
                                <div class="flex-container">
                                    <div class="clickable-square available"></div>
                                    <span class="span-text">Available</span>
                                </div>
                            </td>
                            <td colspan="3" style="text-align: left;padding-left: 12px;">
                                <div class="flex-container">
                                    <div class="clickable-square occupied"></div>
                                    <span class="span-text">Occupied</span>
                                </div>
                            </td>
                            <td colspan="3" style="text-align: left;padding-left: 12px;">
                                <div class="flex-container">
                                    <div class="clickable-square wheelchair"></div>
                                    <span class="span-text">Wheelchair</span>
                                </div>
                            </td>
                            <td colspan="3" style="text-align: left;padding-left: 12px;">
                                <div class="flex-container">
                                    <div class="clickable-square selected"></div>
                                    <span class="span-text">Selected</span>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 10px; background-color: #79747E;"><td colspan="17"></td></tr>
                        <td colspan="17">P L E A S E &nbsp;&nbsp; S E L E C T &nbsp;&nbsp; S E A T S</td>
                    </tfoot>
                </table>
                <form action="../php/add-to-cart.php" method="POST" id="seats-info-form">
                    <input type="hidden" id="hidden-selected-seats" name="hidden-selected-seats">
                    <input type="hidden" id="hidden-total" name="hidden-total"> 
                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
                    <div class="seats-info-container">
                        <div id="seat-info">
                            <div><b>Seats selected: </b><span id="selected-seats">None</span></div><br>
                            <div><b>No. of Tickets ($13 per pax): </b><span id="num-tickets">0</span></div><br>
                            <div><b>Subtotal:</b> $<span id="subtotal">0.00</span></div><br>
                            
                            <!-- Hidden input for the selected time slot -->
                            <?php
                            if (isset($_SESSION['selected_time_slot'])) {
                                echo '<input type="hidden" id="selected-time-slot" name="selected_time_slot" value="' . htmlspecialchars($_SESSION['selected_time_slot']) . '">';
                            } else {
                                echo '<input type="hidden" id="selected-time-slot" name="selected_time_slot" value="None">'; // Default value if no time slot is set
                            }
                            ?>
                        </div>
                        <br>
                        <button type="submit" id="payment-button">Add to Cart <img src="../assets/cart.png" alt="cart icon"/></button>
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
            document.addEventListener("DOMContentLoaded", function() {
                let selectedSeats = [];
                const seatPrice = 13.00; 

                function toggleSeat(element) {
                    let seatId = element.getAttribute('data-seat-id');

                    const seatLetter = seatId.charAt(0); // e.g., "B"
                    let seatNumber = parseInt(seatId.slice(1)); // e.g., 9

                    // If the seat number is greater than 5, subtract 3
                    if (seatNumber > 5) {
                        seatNumber -= 3;
                        seatId = seatLetter + seatNumber; // e.g., "B6"
                    }

                    // Check if the seat is available or a wheelchair seat and select it
                    if (element.classList.contains('available') || element.classList.contains('wheelchair')) {
                        element.classList.remove('available', 'wheelchair');
                        element.classList.add('selected');
                        selectedSeats.push(seatId); // Add the seat ID to the list
                    } 
                    // If the seat is selected, deselect it and revert to its original state
                    else if (element.classList.contains('selected')) {
                        element.classList.remove('selected');
                        element.classList.add('available'); // Assuming it was available initially
                        selectedSeats = selectedSeats.filter(seat => seat !== seatId); // Remove the seat ID from the list
                    }

                    // Update the displayed selected seats and ticket count
                    updateSelectedSeatsDisplay();
                }

                function updateSelectedSeatsDisplay() {
                    const selectedSeatsElement = document.getElementById('selected-seats');
                    const numTicketsElement = document.getElementById('num-tickets');
                    const subtotalElement = document.getElementById('subtotal');
                    const hiddenSelectedSeats = document.getElementById('hidden-selected-seats');
                    const hiddenTotal = document.getElementById('hidden-total');

                    selectedSeats.sort(function(a, b) {

                    const letterA = a.charAt(0);

                    const numberA = parseInt(a.slice(1));



                    const letterB = b.charAt(0);

                    const numberB = parseInt(b.slice(1));



                    // Compare the seat letters using charCodeAt (ASCII values) and the numbers

                    if (letterA === letterB) {

                        return numberA - numberB;

                    } else {

                        return letterA.charCodeAt(0) - letterB.charCodeAt(0);

                    }

                    });

                    selectedSeatsElement.textContent = selectedSeats.length > 0 ? selectedSeats.join(', ') : 'None';
                    numTicketsElement.textContent = selectedSeats.length;
                    const subtotal = (selectedSeats.length * seatPrice).toFixed(2);
                    subtotalElement.textContent = subtotal;

                     // Update the hidden input with adjusted seat IDs
                    const adjustedSeats = selectedSeats.map(seatId => {
                        const seatLetter = seatId.charAt(0); // e.g., "B"
                        let seatNumber = parseInt(seatId.slice(1)); // e.g., 6

                        // If the seat number is 6 or greater, add 3 to get back the original seat ID
                        if (seatNumber > 5) {
                            seatNumber += 3;
                        }

                        return seatLetter + seatNumber; // Return the adjusted seat ID
                    });

                    hiddenSelectedSeats.value = adjustedSeats.join(', '); // Update the hidden input with adjusted seat IDs
                    hiddenTotal.value = subtotal;
                }

                // Add event listeners for seat clicks
                const seatElements = document.querySelectorAll('.clickable-square.available, .clickable-square.wheelchair, .clickable-square.selected');
                seatElements.forEach(seat => {
                    seat.addEventListener('click', function() {
                        toggleSeat(seat);
                    });
                });

                // Handle form submission
                const form = document.getElementById('seats-info-form');
                form.addEventListener('submit', function(event) {
                    if (selectedSeats.length === 0) {
                        alert('Please select at least one seat before proceeding.');
                        event.preventDefault(); // Prevent form submission
                    }
                });
            });
        </script>
    </body>
</html>
