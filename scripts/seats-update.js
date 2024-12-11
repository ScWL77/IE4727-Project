
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

    selectedSeats.sort((a, b) => {
        const [letterA, numberA] = [a.charAt(0), parseInt(a.slice(1))];
        const [letterB, numberB] = [b.charAt(0), parseInt(b.slice(1))];
    
        return letterA === letterB ? numberA - numberB : letterA.localeCompare(letterB);
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


function eventListeners(){
    // Add event listeners for seat clicks
    const seatElements = document.querySelectorAll('.clickable-square.available, .clickable-square.wheelchair, .clickable-square.selected');
    seatElements.forEach(seat => {
        seat.addEventListener('click', function() {
            toggleSeat(seat);
        });
    });

    console.log("Added event listeners to seats");

    // Handle form submission
    const form = document.getElementById('seats-info-form');
    form.addEventListener('submit', function(event) {
        if (selectedSeats.length === 0) {
            alert('Please select at least one seat before proceeding.');
            event.preventDefault(); // Prevent form submission
        }
    });

    console.log("Added event listeners to seats-info-form");

}

document.addEventListener("DOMContentLoaded", function() {
    eventListeners();
    console.log('Event Listeners loaded');
});