// Select the password input and toggle button
const passwordInput = document.getElementById('password');
const togglePasswordButton = document.getElementById('togglePassword');

// Add event listener to toggle button
togglePasswordButton.addEventListener('click', function () {
    // Check the current type of the password input
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    
    // Toggle the type attribute
    passwordInput.setAttribute('type', type);
    
    // Change the button text/icon (optional)
    this.textContent = type === 'password' ? '👁️' : '🙈';
});
