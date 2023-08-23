/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */


const weights = ["<Strong style='color:#00AA00;font-weight: bold'>Light</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Medium</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Heavy</Strong>", "<Strong style='font-weight: bold;color:#FFAA00'>Severe</Strong>", "<Strong style='font-weight: bold;color:#AA0000'>Extreme</Strong>"];
const types = ["<Strong style='color:#00AA00;font-weight: bold'>Chat</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Game</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Misc</Strong>"];
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

function onLoad() {
    $.ajax({
        url:'/punishments/utils/get-stats.php',
        type: 'get',
        success: function(result) {
            result = JSON.parse(result);
            document.getElementById("daily-issued").innerHTML = result["daily"]["issued"];
            document.getElementById("daily-approved").innerHTML = result["daily"]["approved"];
            document.getElementById("daily-denied").innerHTML = result["daily"]["denied"];
            document.getElementById("daily-forums").innerHTML = result["daily"]["forums"];
            document.getElementById("daily-nova").innerHTML = result["daily"]["nova"];

            document.getElementById("monthly-issued").innerHTML = result["monthly"]["issued"];
            document.getElementById("monthly-approved").innerHTML = result["monthly"]["approved"];
            document.getElementById("monthly-denied").innerHTML = result["monthly"]["denied"];
            document.getElementById("monthly-forums").innerHTML = result["monthly"]["forums"];
            document.getElementById("monthly-nova").innerHTML = result["monthly"]["nova"];

            document.getElementById("alltime-issued").innerHTML = result["alltime"]["issued"];
            document.getElementById("alltime-pending").innerHTML = result["alltime"]["pending"];
            document.getElementById("alltime-approved").innerHTML = result["alltime"]["approved"];
            document.getElementById("alltime-denied").innerHTML = result["alltime"]["denied"];
            document.getElementById("alltime-forums").innerHTML = result["alltime"]["forums"];
            document.getElementById("alltime-nova").innerHTML = result["alltime"]["nova"];


            document.getElementById("content").style.display = null;
            document.getElementById("ring").style.display = "none";
        }
    });
}

function onLoadApproved(allowed) {
    if (!allowed) {
        document.getElementById("content").innerHTML = '<p style="text-align: center;padding-top: 20px;font:inherit">You do not have permission to access this page.</p>';
        document.getElementById("content").style.display = null;
        return;
    }

    $.ajax({
        url:'/punishments/utils/get-pending.php',
        type: 'get',
        success: function(result) {
            result = JSON.parse(result);

            let table = document.getElementById("table-values");
            result.forEach(function (punishment) {
                let elem = document.createElement("tr");
                table.appendChild(elem);

                let html = '<td><a href="/punishments/search?code=' + punishment["code"] + '" style="color:white;">' + punishment['code'] + ' ' + ((punishment['status'] === 1 || punishment['status'] === 2 || punishment['status'] === 3) ? '<span class="badge badge-success">ACTIVE</span>' : ((punishment['status'] === 4) ? '<span class="badge badge-danger">SM DENIED</span>' : ((punishment['removal_reason'] !== "N/A") ? '<span class="badge badge-secondary">REMOVED</span>' : '<span class="badge badge-secondary">EXPIRED</span>'))) + ((punishment['status'] === 2) ? '<span class="badge badge-secondary">PENDING APPROVAL</span>' : ((punishment['status'] === 3 || punishment['status'] === 6) ? '<span class="badge badge-success">SM APPROVED</span>' : '')) +'</a></td>' +
                    '<td>' + punishment["punished_name"] +  '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punished_uuid'] +  '?helm=true"></td>' +
                    '<td>' + ((punishment['status'] === 7) ? 'Warning' : ((punishment['type'] === 1) ? 'Mute' : 'Ban')) + ' (' + types[punishment['type'] - 1] + ')' + '</td>' +
                    '<td>' + punishment['rule'] + ' - ' + punishment['notes'] + '</td>' +
                    '<td>' + weights[punishment['weight'] - 1] + '</td>' +
                    '<td>' + new Date(punishment['issued']).toLocaleString() + '</td>' +
                    '<td>' + ((punishment['expire'] === -1) ? 'Permanent' : (((punishment['expire'] - punishment['issued']) / 3600000 >= 24) ? ((punishment['expire'] - punishment['issued']) / 86400000) + ' days' : ((punishment['expire'] - punishment['issued']) / 3600000) + ' hours')) + '</td>' +
                    '<td>' + punishment['punisher_name'] + '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punisher_uuid'] + '?helm=true"></td>';


                if (punishment['removal_reason'] !== "N/A") {
                    html += '<td>' + punishment['removal_reason'] + '</td>' +
                        '<td>' + new Date(punishment['removal_timestamp']).toLocaleString() + '</td>' +
                        '<td>' + punishment['remover'] + '</td>';
                } else {
                    html += '<td>N/A</td>' +
                        '<td>N/A</td>' +
                        '<td>N/A</td>';
                }
                elem.innerHTML = html;
            });

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

function onLoadSearch() {
    $('#punisher').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validateusername(document.getElementById("punishersearch"), document.getElementById("punishersearch").punisher.value, "punisher");
        }
    });

    $('#user').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validateusername(document.getElementById("usersearch"), document.getElementById("usersearch").user.value, "user");
        }
    });
    $('#code').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return validatecode(document.getElementById("codesearch"), document.getElementById("codesearch").code.value);
        }
    });

    document.getElementById("content").style.display = null;
    document.getElementById("ring").style.display = "none";
}

function onLoadUser(user) {
    $.ajax({
        url:'/punishments/utils/get-by-user.php',
        type: 'get',
        data: "user=" + encodeURIComponent(user),
        success: function(result) {
            result = JSON.parse(result);
            if ("error" in result) {
                document.getElementById("content").innerHTML = "<div id='not-found' style='display: none;'>" +
                    "<br>" +
                    "<h2> " + result["error"] + "</h2>" +
                    "</div>" +
                    "<div class=\"row\">" +
                    "<div id=\"chat\" class=\"col-lg-12\">" +
                    "<h4>The requested punishments could not be found. Please try again.</h4>" +
                    "</div>" +
                    "</div>";


                document.getElementById("not-found").style.display = null;
                document.getElementById("content").style.display = null;
                document.getElementById("ring").style.display = "none";
                return;
            }

            let table = document.getElementById("table-values");
            result.forEach(function (punishment) {
                let elem = document.createElement("tr");
                table.appendChild(elem);

                let html = '<td><a href="/punishments/search?code=' + punishment["code"] + '" style="color:white;">' + punishment['code'] + ' ' + ((punishment['status'] === 1 || punishment['status'] === 2 || punishment['status'] === 3) ? '<span class="badge badge-success">ACTIVE</span>' : ((punishment['status'] === 4) ? '<span class="badge badge-danger">SM DENIED</span>' : ((punishment['removal_reason'] !== "N/A") ? '<span class="badge badge-secondary">REMOVED</span>' : '<span class="badge badge-secondary">EXPIRED</span>'))) + ((punishment['status'] === 2) ? '<span class="badge badge-secondary">PENDING APPROVAL</span>' : ((punishment['status'] === 3 || punishment['status'] === 6) ? '<span class="badge badge-success">SM APPROVED</span>' : '')) +'</a></td>' +
                    '<td>' + punishment["punished_name"] +  '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punished_uuid'] +  '?helm=true"></td>' +
                    '<td>' + ((punishment['status'] === 7) ? 'Warning' : ((punishment['type'] === 1) ? 'Mute' : 'Ban')) + ' (' + types[punishment['type'] - 1] + ')' + '</td>' +
                    '<td>' + punishment['rule'] + ' - ' + punishment['notes'] + '</td>' +
                    '<td>' + weights[punishment['weight'] - 1] + '</td>' +
                    '<td>' + new Date(punishment['issued']).toLocaleString() + '</td>' +
                    '<td>' + ((punishment['expire'] === -1) ? 'Permanent' : (((punishment['expire'] - punishment['issued']) / 3600000 >= 24) ? ((punishment['expire'] - punishment['issued']) / 86400000) + ' days' : ((punishment['expire'] - punishment['issued']) / 3600000) + ' hours')) + '</td>' +
                    '<td>' + punishment['punisher_name'] + '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punisher_uuid'] + '?helm=true"></td>';


                if (punishment['removal_reason'] !== "N/A") {
                    html += '<td>' + punishment['removal_reason'] + '</td>' +
                        '<td>' + new Date(punishment['removal_timestamp']).toLocaleString() + '</td>' +
                        '<td>' + punishment['remover'] + '</td>';
                } else {
                    html += '<td>N/A</td>' +
                        '<td>N/A</td>' +
                        '<td>N/A</td>';
                }
                elem.innerHTML = html;
            });

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

            $('#user').keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return validateusername(document.getElementById("usersearch"), document.getElementById("usersearch").user.value, "user");
                }
            });

        }
    });
}

function onLoadPunisher(user) {
    $.ajax({
        url:'/punishments/utils/get-by-punisher.php',
        type: 'get',
        data: "punisher=" + encodeURIComponent(user),
        success: function(result) {
            result = JSON.parse(result);
            if ("error" in result) {
                document.getElementById("content").innerHTML = "<div id='not-found' style='display: none;'>" +
                    "<br>" +
                    "<h2> " + result["error"] + "</h2>" +
                    "</div>" +
                    "<div class=\"row\">" +
                    "<div id=\"chat\" class=\"col-lg-12\">" +
                    "<h4>The requested punishments could not be found. Please try again.</h4>" +
                    "</div>" +
                    "</div>";


                document.getElementById("not-found").style.display = null;
                document.getElementById("content").style.display = null;
                document.getElementById("ring").style.display = "none";
                return;
            }

            let table = document.getElementById("table-values");
            result.forEach(function (punishment) {
                let elem = document.createElement("tr");
                table.appendChild(elem);

                let html = '<td><a href="/punishments/search?code=' + punishment["code"] + '" style="color:white;">' + punishment['code'] + ' ' + ((punishment['status'] === 1 || punishment['status'] === 2 || punishment['status'] === 3) ? '<span class="badge badge-success">ACTIVE</span>' : ((punishment['status'] === 4) ? '<span class="badge badge-danger">SM DENIED</span>' : ((punishment['removal_reason'] !== "N/A") ? '<span class="badge badge-secondary">REMOVED</span>' : '<span class="badge badge-secondary">EXPIRED</span>'))) + ((punishment['status'] === 2) ? '<span class="badge badge-secondary">PENDING APPROVAL</span>' : ((punishment['status'] === 3 || punishment['status'] === 6) ? '<span class="badge badge-success">SM APPROVED</span>' : '')) +'</a></td>' +
                    '<td>' + punishment["punished_name"] +  '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punished_uuid'] +  '?helm=true"></td>' +
                    '<td>' + ((punishment['status'] === 7) ? 'Warning' : ((punishment['type'] === 1) ? 'Mute' : 'Ban')) + ' (' + types[punishment['type'] - 1] + ')' + '</td>' +
                    '<td>' + punishment['rule'] + ' - ' + punishment['notes'] + '</td>' +
                    '<td>' + weights[punishment['weight'] - 1] + '</td>' +
                    '<td>' + new Date(punishment['issued']).toLocaleString() + '</td>' +
                    '<td>' + ((punishment['expire'] === -1) ? 'Permanent' : (((punishment['expire'] - punishment['issued']) / 3600000 >= 24) ? ((punishment['expire'] - punishment['issued']) / 86400000) + ' days' : ((punishment['expire'] - punishment['issued']) / 3600000) + ' hours')) + '</td>' +
                    '<td>' + punishment['punisher_name'] + '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punisher_uuid'] + '?helm=true"></td>';


                if (punishment['removal_reason'] !== "N/A") {
                    html += '<td>' + punishment['removal_reason'] + '</td>' +
                        '<td>' + new Date(punishment['removal_timestamp']).toLocaleString() + '</td>' +
                        '<td>' + punishment['remover'] + '</td>';
                } else {
                    html += '<td>N/A</td>' +
                        '<td>N/A</td>' +
                        '<td>N/A</td>';
                }
                elem.innerHTML = html;
            });

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

            $('#punisher').keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return validateusername(document.getElementById("punishersearch"), document.getElementById("punishersearch").punisher.value, "punisher");
                }
            });

        }
    });
}

function onLoadCode(user) {
    $.ajax({
        url:'/punishments/utils/get-by-code.php',
        type: 'get',
        data: "code=" + encodeURIComponent(user),
        success: function(result) {
            let punishment = JSON.parse(result);
            if ("error" in punishment) {
                document.getElementById("content").innerHTML = "<div id='not-found' style='display: none;'>" +
                    "<br>" +
                    "<h2> " + result["error"] + "</h2>" +
                    "</div>" +
                    "<div class=\"row\">" +
                    "<div id=\"chat\" class=\"col-lg-12\">" +
                    "<h4>The requested punishment could not be found. Please try again.</h4>" +
                    "</div>" +
                    "</div>";


                document.getElementById("not-found").style.display = null;
                document.getElementById("content").style.display = null;
                document.getElementById("ring").style.display = "none";
                return;
            }

            document.getElementById("badges").innerHTML = ((punishment['status'] === 1 || punishment['status'] === 2 || punishment['status'] === 3) ? '<span class="badge badge-success">ACTIVE</span>' : ((punishment['status'] === 4) ? '<span class="badge badge-danger">SM DENIED</span>' : ((punishment['removal_reason'] !== "N/A") ? '<span class="badge badge-secondary">REMOVED</span>' : '<span class="badge badge-secondary">EXPIRED</span>'))) + ((punishment['status'] === 2) ? '<span class="badge badge-secondary">PENDING APPROVAL</span>' : ((punishment['status'] === 3 || punishment['status'] === 6) ? '<span class="badge badge-success">SM APPROVED</span>' : ''));
            document.getElementById("image").src = "https://crafatar.com/renders/body/" + punishment["punished_uuid"] + "?helm=true";
            document.getElementById("punished").innerHTML = punishment["punished_name"];
            document.getElementById("type").innerHTML = ((punishment['status'] === 7) ? 'Warning' : ((punishment['type'] === 1) ? 'Mute' : 'Ban')) + ' (' + types[punishment['type'] - 1] + ')';
            document.getElementById("reason").innerHTML = punishment['rule'] + ' - ' + punishment['notes'];
            document.getElementById("weight").innerHTML = weights[punishment['weight'] - 1];
            document.getElementById("issued").innerHTML = new Date(punishment['issued']).toLocaleString();
            document.getElementById("expire").innerHTML = ((punishment['expire'] === -1) ? 'Permanent' : (((punishment['expire'] - punishment['issued']) / 3600000 >= 24) ? ((punishment['expire'] - punishment['issued']) / 86400000) + ' days' : ((punishment['expire'] - punishment['issued']) / 3600000) + ' hours'));
            document.getElementById("punisher").innerHTML = punishment['punisher_name'] + '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['punisher_uuid'] + '?helm=true">';

            let buttons = "";
            if (punishment['removal_reason'] !== "N/A") {
                document.getElementById("remover").innerHTML = punishment['remover'];
                document.getElementById("removal-reason").innerHTML = punishment['removal_reason'];
                document.getElementById("removal-timestamp").innerHTML = new Date(punishment['removal_timestamp']).toLocaleString();
            } else {
                document.getElementById("remover").innerHTML = "N/A";
                document.getElementById("removal-reason").innerHTML = "N/A";
                document.getElementById("removal-timestamp").innerHTML = "N/A";
                if (punishment["status"] !== 7) {
                    document.getElementById("remove-modal").innerHTML = "" +
                        "<div class=\"modal fade\" id=\"myModal\">" +
                        "   <div class=\"modal-dialog\">" +
                        "       <div class=\"modal-content\">" +
                        "           <div class=\"modal-header\">" +
                        "               <h4 class=\"modal-title\" style=\"color: black\">Remove a punishment</h4>" +
                        "               <button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>" +
                        "           </div>" +
                        "           <div class=\"modal-body\">" +
                        "               <form method=\"post\" name=\"login_form\">" +
                        "                   <fieldset>" +
                        "                   <div class=\"md-form\">" +
                        "                       <input type=\"text\" id=\"removalReason\" class=\"form-control\">" +
                        "                       <label for=\"removalReason\">Reason</label>" +
                        "                   </div>" +
                        "                   <input type=\"button\" value=\"Remove\" onclick=\"removePunishment('" + punishment["code"] + "', this.form.removalReason.value, " + punishment["type"] + ", '" + punishment["punished_uuid"] + "'," + punishment["status"] + ")\" class=\"btn btn-success\" data-dismiss=\"modal\"/>" +
                        "               </form>" +
                        "           </div>" +
                        "           <div class=\"modal-footer\">" +
                        "               <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button>" +
                        "           </div>" +
                        "       </div>" +
                        "   </div>" +
                        "</div>"
                    if (punishment["status"] === 2) {
                        buttons = '<button type="button" class="btn btn-success" onclick=\'approvePunishment("' + punishment["code"] + '", ' + punishment["type"] + ', "' + punishment["punished_uuid"] + '")\'><i class="fas fa-thumbs-up"></i><br>Approve Punishment</button><button type="button" class="btn btn-warning" onclick=\'denyPunishment("' + punishment["code"] + '", ' + punishment["type"] + ', "' + punishment["punished_uuid"] + '")\'><i class="fas fa-thumbs-down"></i><br>Deny Punishment</button>';
                    }
                    buttons += '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal" ><i class="fas fa-minus"></i><br>Remove Punishment</button></div></div>';
                    document.getElementById("buttons").innerHTML = buttons;
                }
            }

            if (punishment['evidence'] !== "NONE") {
                document.getElementById("evidence").innerHTML = "<a href='" + punishment['evidence'] + "' style='color: white'>CLICK HERE!</a>";
            } else {
                document.getElementById("evidence").innerHTML = "NONE";
            }

            document.getElementById("content").style.display = null;
            document.getElementById("ring").style.display = "none";

            $('#code').keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return validatecode(document.getElementById("codesearch"), document.getElementById("codesearch").code.value);
                }
            });

        }
    });
}

function onLoadNotes(user) {
    if (!user) {
        document.getElementById("content").style.display = null;
        document.getElementById("ring").style.display = "none";

        $('#user').keydown(function(event){
            if(event.keyCode === 13) {
                event.preventDefault();
                return validateusername(document.getElementById("usersearch"), document.getElementById("usersearch").user.value, "user");
            }
        });
        return
    }
    $.ajax({
        url:'/punishments/utils/get-notes.php',
        type: 'get',
        data: "user=" + encodeURIComponent(user),
        success: function(result) {
            result = JSON.parse(result);
            if ("error" in result) {
                document.getElementById("content").innerHTML = "<div id='not-found' style='display: none;'>" +
                    "<br>" +
                    "<h2> " + result["error"] + "</h2>" +
                    "</div>" +
                    "<div class=\"row\">" +
                    "<div id=\"chat\" class=\"col-lg-12\">" +
                    "<h4>The requested punishments could not be found. Please try again.</h4>" +
                    "</div>" +
                    "</div>";


                document.getElementById("not-found").style.display = null;
                document.getElementById("content").style.display = null;
                document.getElementById("ring").style.display = "none";
                return;
            }

            let table = document.getElementById("table-values");
            result.forEach(function (punishment) {
                let elem = document.createElement("tr");
                table.appendChild(elem);
                elem.innerHTML = '<td>' + punishment['note_id'] + '</td>' +
                    '<td>' + punishment["name"] +  '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['uuid'] +  '?helm=true"></td>' +
                    '<td>' + punishment["note"] + '</td>' +
                    '<td>' + new Date(punishment['timestamp']).toLocaleString() + '</td>' +
                    '<td>' + punishment['added_by'] + '<img style="height:50px" src="https://crafatar.com/renders/head/' + punishment['added_by_uuid'] + '?helm=true"></td>';
            });

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

            $('#user').keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return validateusername(document.getElementById("usersearch"), document.getElementById("usersearch").user.value, "user");
                }
            });

        }
    });
}