// Function to display error message above the form
function displayError(formName, message) {
    var errorDiv = document.getElementById(formName + "-error");
    errorDiv.innerHTML = message;
    errorDiv.style.display = "block";
}

// Function to validate the registration form
function validateRegistrationForm() {
    var username = document.forms["registerForm"]["username"].value;
    var email = document.forms["registerForm"]["email"].value;
    var password = document.forms["registerForm"]["password"].value;
    var confirmPassword = document.forms["registerForm"]["confirmPassword"].value;

    // Clear any previous error message
    displayError("registerForm", "");

    // Check if any field is empty
    if (username == "" || email == "" || password == "" || confirmPassword == "") {
        displayError("registerForm", "All fields must be filled out");
        return false;
    }

    // Check if password and confirm password match
    if (password !== confirmPassword) {
        displayError("registerForm", "Passwords do not match");
        return false;
    }

    // Check if password length is at least 6 characters
    if (password.length < 6) {
        displayError("registerForm", "Password must be at least 6 characters long");
        return false;
    }

    return true; // If everything is correct
}

// Function to validate the login form
function validateLoginForm() {
    var username = document.forms["loginForm"]["username"].value;
    var password = document.forms["loginForm"]["password"].value;

    // Clear any previous error message
    displayError("loginForm", "");

    // Check if fields are empty
    if (username == "" || password == "") {
        displayError("loginForm", "Both username and password must be filled out");
        return false;
    }

    return true; // If everything is correct
}
