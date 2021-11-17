// If you don't want the particles, change the following to false
const doParticles = true;


// Get the input field
var input = document.getElementById("code");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        formhash(document.getElementById("login_form"), document.getElementById("username").value, document.getElementById("password").value, document.getElementById("code").value);
    }
});

// Do not mess with the rest of this file unless you know what you're doing

const getWidth = () => { // credit to travis on stack overflow
    return Math.max(
        document.body.scrollWidth,
        document.documentElement.scrollWidth,
        document.body.offsetWidth,
        document.documentElement.offsetWidth,
        document.documentElement.clientWidth
    );
};

if (doParticles) {
    if (getWidth() < 400) $.firefly({
        minPixel: 1,
        maxPixel: 2,
        total: 20
    });
    else $.firefly({
        minPixel: 1,
        maxPixel: 3,
        total: 40
    });
}

function formhash(form, username, password, code) {
    // Create a new element input, this will be our hashed password field.
    if (username === '' || password === '' || code === '') {
        return false;
    }

    // Finally submit the form.
    form.submit();
}