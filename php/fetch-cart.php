<?php
// Include the database connection
include 'dbconnect.php'; // Adjust path as needed

// if (!isset($_SESSION['userID'])) {
//     // Redirect to login if user is not logged in
//     header("Location: login-register.php");
//     exit();
// }

$userID = $_SESSION['userID'];

// Function to fetch cart data for the specified userID
function fetchCartData($conn, $userID) {
    $sql = "SELECT * FROM cart WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to fetch movie details using movieID
function fetchMovieDetails($conn, $movieID) {
    $sql = "SELECT title, poster FROM movies WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movieID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to adjust seat numbers based on the seat rules
function adjustSeats($seatsSelected) {
    return implode(",", array_map(function($seatId) {
        $seatId = trim($seatId);
        $seatNumber = intval(substr($seatId, 1));
        $seatLetter = substr($seatId, 0, 1);
        return $seatNumber > 5 ? $seatLetter . ($seatNumber - 3) : $seatId;
    }, explode(',', $seatsSelected)));
}

// Initialize total price
$totalPrice = 0;

// Check if the 'clashedMovieIDs' session variable is set
$clashedMovieIDs = isset($_SESSION['clashedMovieIDs']) ? $_SESSION['clashedMovieIDs'] : [];


// Fetch cart data
$result = fetchCartData($conn, $userID);

while ($row = $result->fetch_assoc()):
    $movieID = $row['movieID'];
    $movie = fetchMovieDetails($conn, $movieID);
    
    $price = $row['total'];
    $numberOfTickets = $row['numberOfTickets'];
    $totalPrice += $price;

    $adjustedSeats = adjustSeats($row['seatsSelected']);

    $isClash = in_array($movieID, $clashedMovieIDs);
?>
    <tr>
        <td>
            <img src="<?= htmlspecialchars($movie['poster']); ?>" alt="<?= htmlspecialchars($movie['title']); ?>" width="100px"/>
            <?php if ($isClash): ?>
                <p style="color: red; font-size: 14px;">Booking clash detected for this movie.</p>
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($movie['title']); ?></td>
        <td><?= htmlspecialchars($row['date']); ?>,   <?= htmlspecialchars($row['time']); ?></td>
        <td><?= htmlspecialchars($row['outlet']); ?></td>
        <td>$<?= htmlspecialchars($price); ?> (x<?= htmlspecialchars($numberOfTickets); ?>)</td>
        <td><?= htmlspecialchars($adjustedSeats); ?></td>
        <td>
            <a href="../php/delete-booking.php?id=<?= $row['bookingID']; ?>" id="delete" onclick="return confirm('Are you sure you want to delete this booking?');">
                <img src="../assets/delete-icon.png" alt="delete icon" width="25px"/>
            </a>
        </td>
    </tr>
<?php endwhile; ?>

<?php
// Clear session variables after displaying
unset($_SESSION['clashes']);
unset($_SESSION['clashedMovieIDs']);
?>

<!-- Output the total price as a hidden input for reference -->
<input type="hidden" id="total-price" value="<?= number_format($totalPrice, 2); ?>">