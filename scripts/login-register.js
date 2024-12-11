var login_form= document.getElementById("login");
var signup_form= document.getElementById("signup");
var btn = document.getElementById("btn");

function signup(){
    login_form.style.left="-400px";
    signup_form.style.left="50px";
    btn.style.left = "110px";
}

function login(){
    login_form.style.left="50px";
    signup_form.style.left="450px";
    btn.style.left = "0px";
}

window.addEventListener('scroll', function() {
    const footer = document.querySelector('footer');
    const scrollPosition = window.innerHeight + window.scrollY;
    const documentHeight = document.documentElement.scrollHeight;

    if (scrollPosition >= documentHeight) {
        footer.classList.add('visible');
    } else {
        footer.classList.remove('visible');
    }
});


// Function to clear error messages
function clearErrors() {
    document.getElementById('username_error').textContent = '';
    document.getElementById('contact_error').textContent = '';
    document.getElementById('email_error').textContent = '';
    document.getElementById('password_error').textContent = '';
}

// Function to validate each input field
function validateInput(inputElement, pattern, errorMessageId, errorMessage) {
    if (!pattern.test(inputElement.value.trim())) {
        document.getElementById(errorMessageId).textContent = errorMessage;
        return false; // Return false if validation fails
    }
    return true; // Return true if validation passes
}

// Get references to the input fields
const signupForm = document.getElementById('signup');
const usernameField = document.getElementById('signup_username');
const contactField = document.getElementById('signup_contact');
const emailField = document.getElementById('signup_email');
const passwordField = document.getElementById('signup_password');

// Attach input event listeners for real-time validation
usernameField.addEventListener('input', function() {
    clearErrors();
    validateInput(usernameField, /^([A-z\s]+)$/, 'username_error', 'Username should contain alphabet characters and spaces only');
});

contactField.addEventListener('input', function() {
    clearErrors();
    validateInput(contactField, /^[0-9]{8}$/, 'contact_error', 'Contact number must be exactly 8 digits.');
});

emailField.addEventListener('input', function() {
    clearErrors();
    validateInput(emailField, /^[\w.-]+@[\w]+(\.[\w]+){0,2}\.[\w]{2,3}$/, 'email_error', 'Please enter a valid email address.');
});

passwordField.addEventListener('input', function() {
    clearErrors();
    validateInput(passwordField, /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/, 'password_error', 'Password must be 8-15 characters long and include uppercase, lowercase, a number, and a special character.');
});