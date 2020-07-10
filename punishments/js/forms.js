function validatecode(form, code) {
    let re = /^[A-Za-z0-9]{8}$/
    if (!re.test(code)) {
        document.getElementById("alerts-code").innerHTML = "<div class='alert alert-danger alert-dismissible fade show'  role='alert'>The code you provided was invalid. Please try again.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        return false;
    }

    form.code.value = form.code.value.toUpperCase();
    form.submit();
    return true;
}

function validateusername(form, code, type) {
    let re = /^[A-Za-z0-9_]{1,16}$/
    if (!re.test(code)) {
        document.getElementById("alerts-" + type).innerHTML = "<div class='alert alert-danger alert-dismissible fade show'  role='alert'>The username you provided was invalid. Please try again.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        return false;
    }
    form.submit();
    return true;
}

function removePunishment(id, reason, type, uuid, status) {
    if (reason === '') {
        alert("You must provide a reason!");
        return;
    }
    $.ajax({
        url:'/punishments/utils/functions.php',
        type: 'post',
        data: "remove=" + id + "&reason=" + encodeURIComponent(reason) + "&type=" + type + "&uuid=" + uuid + "&status=" + status,
        success: function(result) {
            alert("Punishment removed");
            location.reload();
        }
    });
}

function approvePunishment(id, type, uuid) {
    $.ajax({
        url:'/punishments/utils/functions.php',
        type: 'post',
        data: "approve=" + id + "&type=" + type + "&uuid=" + uuid,
        success: function(result) {
            alert("Punishment approved!");
            location.reload();
        }
    });
}

function denyPunishment(id, type, uuid) {
    $.ajax({
        url:'/punishments/utils/functions.php',
        type: 'post',
        data: "deny=" + id + "&type=" + type + "&uuid=" + uuid,
        success: function(result) {
            alert("Punishment denied!");
            location.reload();
        }
    });
}

$(document).ready(function() {
    $('#code').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validatecode(document.getElementById("codesearch"), document.getElementById("codesearch").code.value);
        }
    });
});

$(document).ready(function() {
    $('#user').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validateusername(document.getElementById("usersearch"), document.getElementById("usersearch").user.value, "user");
        }
    });
});

$(document).ready(function() {
    $('#punisher').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validateusername(document.getElementById("punishersearch"), document.getElementById("punishersearch").punisher.value, "punisher");
        }
    });
});