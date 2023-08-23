/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

function validateusername(form, code, type) {
    let re = /^[A-Za-z0-9_]{1,16}$/
    if (!re.test(code)) {
        document.getElementById("alerts-" + type).innerHTML = "<div class='alert alert-danger alert-dismissible fade show'  role='alert'>The username you provided was invalid. Please try again.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        return false;
    }

    $.ajax({
        url:'/blacklist/utils/functions.php',
        type: 'post',
        data: "add=" + code,
        success: function(result) {
            form.user.value = "";
        }
    });
    return true;
}

function onLoad() {
    $.ajax({
        url:'/blacklist/utils/total-blacklisted.php',
        type: 'get',
        success: function(result) {
            document.getElementById("names").innerText = result;
            document.getElementById("content").style.display = null;
            document.getElementById("ring").style.display = "none";
        }
    });
}

function onLoadBlacklist() {
    $.ajax({
        url:'/blacklist/utils/blacklisted-names.php',
        type: 'get',
        success: function(result) {
            console.log(result);
            let names = JSON.parse(result);
            let table = document.getElementById("table-values");
            names.forEach(function (name) {
                let row = document.createElement("tr");
                row.id = name;
                table.appendChild(row)
                row.innerHTML = "" +
                    "<td>" + name + "</td>" +
                    "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"removeUser('" + name + "')\"><i class=\"fas fa-trash-alt\"></i> Remove</button></td>\n"
            })
            document.getElementById("content").style.display = null;
            $('#dtHistory').DataTable({
                "pagingType": "full_numbers", // "simple" option for 'Previous' and 'Next' buttons only
                "autoWidth": true,
                "scrollY": "498px",
                "scrollCollapse": true,
                "ordering": false
            });
            $('.dataTables_length').addClass('bs-select');

            document.getElementById("ring").style.display = "none";
        }
    });
}

function removeUser(username) {
    //AJAX remove the user from the blacklist
    $.ajax({
        url:'/blacklist/utils/functions.php',
        type: 'post',
        data: "remove=" + username,
        success: function(result) {
            document.getElementById(username).remove();
        }
    });
}

$(document).ready(function() {
    $('#user').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validateusername(document.getElementById("usersearch"), document.getElementById("usersearch").user.value, "user");
        }
    });
});