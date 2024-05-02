//This event listener ensures that the DOM content is fully loaded before executing the code inside.
document.addEventListener('DOMContentLoaded', function () {

    //Select the toggle button and password input field
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    //Select the toggle button and confirm password input field
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirmPassword');

    //Add a click event listener to the password toggle button
    togglePassword.addEventListener('click', function () {
        // all the function to toggle password visibility
        togglePasswordVisibility(password, togglePassword);
    });

    //Add a click event listener to the confirm password toggle button
    toggleConfirmPassword.addEventListener('click', function () {
        //Call the function to toggle confirm password visibility
        togglePasswordVisibility(confirmPassword, toggleConfirmPassword);
    });

    //Function to toggle the visibility of the password or confirm password
    function togglePasswordVisibility(inputField, eyeIcon) {
        //Determine the current type of the input field (password or text)
        const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
        
        //Set the new type for the input field
        inputField.setAttribute('type', type);

        //Toggle the eye icon class between 'bi-eye-slash' and 'bi-eye'
        eyeIcon.classList.toggle('bi-eye-slash');
        eyeIcon.classList.toggle('bi-eye');
    }
});