/*
 * Copyright (c) 2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

function onLoad() {
    $.ajax({
        url:'/watchdog/utils/unresolved-total.php',
        type: 'get',
        success: function(result) {
            document.getElementById("exceptions").innerHTML = result;
            $.ajax({
                url:'/watchdog/utils/total.php',
                type: 'get',
                success: function(result) {
                    document.getElementById("exceptions-total").innerHTML = result;

                    document.getElementById("content").style.display = null;
                    document.getElementById("ring").style.display = "none";
                }
            });
        }
    });
}

function onLoadExceptions(code) {
    if (!code) {
        $.ajax({
            url:'/watchdog/utils/unresolved.php',
            type: 'get',
            success: function(result) {
                let data = JSON.parse(result);
                if ("error" in data) {
                    console.log(data["error"])
                    document.title = "Exception Not Found | Watchdog | The AuroraMC Network"
                    document.getElementById("content").innerHTML = "<div id='not-found' style='display: none;'>" +
                        "<br>" +
                        "<h2> " + data["error"] + "</h2>" +
                        "</div>" +
                        "<div class=\"row\">" +
                        "<div id=\"chat\" class=\"col-lg-12\">" +
                        "<h4>The requested exception could not be found. Please try again.</h4>" +
                        "</div>" +
                        "</div>";


                    document.getElementById("not-found").style.display = null;
                    document.getElementById("content").style.display = null;
                    document.getElementById("ring").style.display = "none";
                    return;
                }
                let table = document.getElementById("table-values");
                data.forEach(function (exceptionRaw) {
                    let exception = JSON.parse(exceptionRaw);
                    let serverData = JSON.parse(exception["server_data"]);
                    let elem = document.createElement("tr");
                    table.appendChild(elem)

                    elem.innerHTML = "<td>" + exception["uuid"] + "</td>" +
                        "<td>" + new Date(parseInt(exception["timestamp"])).toLocaleString() + "</td>" +
                        "<td>" + exception["exception"] + "</td>" +
                        "<td>" + exception["location"] + "-" + serverData["network"] + "</td>" +
                        (("player_name" in exception)?"<td>" + exception["player_name"] + "</td>":"<td>N/A</td>") +
                        "<td>" + exception["command"] + "</td>" +
                        "<td><button type='button' class='btn btn-secondary' onclick='window.location=\x22" + "exceptions?uuid=" +  exception["uuid"] + "\x22'><i class=\"fas fa-eye\"></i> View</button></td>"
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
    } else {
        $.ajax({
            url:'/watchdog/utils/unresolved-trace.php',
            type: 'post',
            data: "uuid=" + encodeURIComponent(code),
            success: function(result) {
                let data = JSON.parse(result);
                if ("error" in data) {
                    console.log(data["error"])
                    document.title = "Exception Not Found | Watchdog | The AuroraMC Network"
                    document.getElementById("content").innerHTML = "<div id='not-found' style='display: none;'>" +
                        "<br>" +
                        "<h2> " + data["error"] + "</h2>" +
                        "</div>" +
                        "<div class=\"row\">" +
                        "<div id=\"chat\" class=\"col-lg-12\">" +
                        "<h4>The requested exception could not be found. Please try again.</h4>" +
                        "</div>" +
                        "</div>";


                    document.getElementById("not-found").style.display = null;
                    document.getElementById("content").style.display = null;
                    document.getElementById("ring").style.display = "none";
                    return;
                }

                let buttons = "";
                document.getElementById("title").innerHTML = "Exception " + code + " " +  ((data["resolved"])?"<span class='badge badge-success'>RESOLVED</span>":"<span class='badge badge-danger'>UNRESOLVED</span>")

                let serverData = JSON.parse(data["server_data"]);


                document.getElementById("trace").innerText = data["trace"];

                document.getElementById("code").innerText = code;
                document.getElementById("timestamp").innerHTML = new Date(parseInt(data["timestamp"])).toLocaleString();
                document.getElementById("location").innerHTML = data["server"];
                document.getElementById("network").innerHTML = serverData["network"];
                document.getElementById("player").innerHTML = data["player_name"];
                document.getElementById("occurred").innerHTML = data["other_occurrences"];
                document.getElementById("command").innerHTML = data["command"];
                if (data["issue"] !== "NONE") {
                    document.getElementById("issue").innerHTML = "<a href='https://auroramc1617983547.atlassian.net/browse/" + data["issue"] + "' style='color: white'>" + data["issue"] + "</a>";
                } else {
                    document.getElementById("issue").innerHTML = data["issue"];
                    document.getElementById("issue-modal").innerHTML = "<div class=\"modal fade\" id=\"myModal\">" +
                        "<div class=\"modal-dialog\">" +
                        "<div class=\"modal-content\">" +
                        "<!-- Modal Header -->" +
                        "<div class=\"modal-header\">" +
                        "<h4 class=\"modal-title\" style=\"color: black\">Attach a JIRA Issue</h4>" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>" +
                        "</div>" +
                        "<!-- Modal body -->" +
                        "<div class=\"modal-body\">" +
                        "<form method=\"post\" name=\"login_form\">" +
                        "<fieldset>" +
                        "<div class=\"md-form\">" +
                        "<input type=\"text\" id=\"issue\" class=\"form-control\">" +
                        "<label for=\"issue\">Issue</label>" +
                        "</div>" +
                        "<input type=\"button\" value=\"Attach Issue\" onclick=\"attachIssue(this.form.issue.value, '" + code + "')\" class=\"btn btn-success\" data-dismiss=\"modal\"/>" +
                        "</form>" +
                        "</div>" +
                        "<!-- Modal footer -->" +
                        "<div class=\"modal-footer\">" +
                        "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                    buttons += "<button type=\"button\" class=\"btn btn-secondary\"  data-toggle=\"modal\" data-target=\"#myModal\" id='attach-issue' ><i class=\"fas fa-paperclip\"></i><br>Attach Issue</button>"
                }

                if (!data["resolved"]) {
                    buttons += "<button type=\"button\" class=\"btn btn-success\" onclick=\"resolve('" + code + "')\" id='mark-resolved'><i class=\"fas fa-thumbs-up\"></i><br>Mark as Resolved</button>"
                }

                document.getElementById("buttons").innerHTML = buttons + "<br><br>";

                let plugins = serverData["plugins"];
                let str = "";
                plugins.forEach(function (plugin) {
                    str +=  "Name: " + plugin["name"] + "<br>";
                    str +=  "Build: " + plugin["build"] + "<br>";
                    str += "Branch: " + plugin["branch"] + "<br>";
                    str += "Commit: " + plugin["commit"] + "<br><br>";
                })
                document.getElementById("server-data").innerHTML = str;



                document.getElementById("content").style.display = null;
                document.getElementById("ring").style.display = "none";
            }
        });
    }
}

function attachIssue(issue, uuid) {
    if (issue === '' || uuid === '') {
        alert("You must provide an issue or UUID!");
        return;
    }

    $.ajax({
        url:'/watchdog/utils/attach-issue.php',
        type: 'post',
        data: "uuid=" + encodeURIComponent(uuid) + "&issue=" + encodeURIComponent(issue),
        success: function(result) {
            document.getElementById("attach-issue").remove();
            document.getElementById("issue").innerHTML = "<a href='https://auroramc1617983547.atlassian.net/browse/" + issue + "' style='color: white'>" + issue + "</a>";
            alert("Issue attached!");
        }
    });
}

function resolve(uuid) {
    if (uuid === '') {
        alert("You must provide an UUID!");
        return;
    }
    $.ajax({
        url:'/watchdog/utils/resolve.php',
        type: 'post',
        data: "uuid=" + encodeURIComponent(uuid),
        success: function(result) {
            document.getElementById("mark-resolved").remove();
            alert("Exception resolved!");
            window.location = "exceptions"
        }
    });
}
