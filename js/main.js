// If you don't want the particles, change the following to false
const doParticles = true;




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

function formhash(form, username, password) {
    // Create a new element input, this will be our hashed password field.
    if (username.value === '' || password === '') {
        document.getElementById("alerts").innerHTML = "<div class='alert alert-warning alert-dismissible fade in'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>WARNING!</strong> Please make sure you fill out all of the fields!</div>";
        return false;
    }
    var p = document.createElement("input");

    // Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent.
    password.value = "";

    // Finally submit the form.
    form.submit();
}