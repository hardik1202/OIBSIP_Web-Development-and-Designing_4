// script.js - Contains all the logic for our student-level authentication

// Helper function to display messages to the user
function showMessage(elementId, message, isError) {
    const msgElement = document.getElementById(elementId);
    if (msgElement) {
        msgElement.innerText = message;
        msgElement.className = isError ? "error" : "success";
    }
}

// Function to handle Registration
function handleRegister(event) {
    event.preventDefault(); // Stop the form from submitting normally

    const usernameInput = document.getElementById('username').value;
    const passwordInput = document.getElementById('password').value;

    // Get the existing users from localStorage, or start a new empty array if none exist
    let users = JSON.parse(localStorage.getItem('users')) || [];

    // Check if the username is already taken
    const userExists = users.some(user => user.username === usernameInput);

    if (userExists) {
        showMessage('registerMessage', 'Username already exists. Please choose another one.', true);
    } else {
        // Add the new user to our array
        users.push({ username: usernameInput, password: passwordInput });
        
        // Save the updated array back to localStorage
        localStorage.setItem('users', JSON.stringify(users));
        
        showMessage('registerMessage', 'Registration successful! You can now login.', false);
        
        // Clear the form
        document.getElementById('registerForm').reset();
    }
}

// Function to handle Login
function handleLogin(event) {
    event.preventDefault(); // Stop the form from submitting normally

    const usernameInput = document.getElementById('username').value;
    const passwordInput = document.getElementById('password').value;

    // Get the existing users from localStorage
    let users = JSON.parse(localStorage.getItem('users')) || [];

    // Find a user that matches the username AND password
    const foundUser = users.find(user => user.username === usernameInput && user.password === passwordInput);

    if (foundUser) {
        // Login successful! Save the current user in sessionStorage
        sessionStorage.setItem('currentUser', foundUser.username);
        
        // Redirect to the dashboard
        window.location.href = 'index.html';
    } else {
        showMessage('loginMessage', 'Invalid username or password.', true);
    }
}

// Function to check if the user is logged in (Auth Guard for index.html)
function checkAuth() {
    const currentUser = sessionStorage.getItem('currentUser');
    
    // If there is no current user, they are not logged in
    if (!currentUser) {
        // Redirect them back to the login page
        window.location.href = 'login.html';
    } else {
        // Display their name on the dashboard
        document.getElementById('welcomeMessage').innerText = 'Welcome, ' + currentUser + '!';
    }
}

// Function to handle Logout
function handleLogout() {
    // Remove the current user from sessionStorage
    sessionStorage.removeItem('currentUser');
    
    // Redirect back to login page
    window.location.href = 'login.html';
}
