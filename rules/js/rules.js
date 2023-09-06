/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

function startNameEdit(id) {
    var name = document.getElementById(id + "-name").innerHTML;
    document.getElementById(id + "-name").innerHTML = "";

    document.getElementById(id + "-name").innerHTML = "<input class='form-control mr-sm-2' type='text' placeholder='" + name + "' id='" + id + "-newname'>";
    document.getElementById(id + "-edit-name").setAttribute("onclick", "editName(" + id + ")");
    document.getElementById(id + "-edit-name").setAttribute("class", "btn btn-success");
    document.getElementById(id + "-edit-name").innerHTML = "<i class='fas fa-save'></i> Save";

    //Make the edit desc disappear.
    document.getElementById(id + "-edit-desc").setAttribute("style", "visibility: hidden;");

    document.getElementById(id + "-archive").innerHTML = "<i class='fas fa-times'></i> Cancel";
    document.getElementById(id + "-archive").setAttribute("onclick", "cancelName(" + id + ")");
}

function cancelName(id) {
    document.getElementById(id + "-archive").innerHTML = "<i class='fas fa-trash-alt'></i> Archive";
    document.getElementById(id + "-archive").setAttribute("onclick", "archive(" + id + ")");

    document.getElementById(id + "-name").innerHTML = document.getElementById(id + "-newname").getAttribute("placeholder");
    document.getElementById(id + "-edit-name").setAttribute("onclick", "startNameEdit(" + id + ")");
    document.getElementById(id + "-edit-name").setAttribute("class", "btn btn-secondary");
    document.getElementById(id + "-edit-name").innerHTML = "<i class='fas fa-pencil-alt'></i> Edit Name";

    //Make the edit desc reappear.
    document.getElementById(id + "-edit-desc").setAttribute("style", "");

}

function startDescEdit(id) {
    var name = document.getElementById(id + "-description").innerHTML;
    document.getElementById(id + "-description").innerHTML = "";

    document.getElementById(id + "-description").innerHTML = "<input class='form-control mr-sm-2' type='text' placeholder='" + name + "' id='" + id + "-newdesc'>";
    document.getElementById(id + "-edit-desc").setAttribute("onclick", "editDesc(" + id + ")");
    document.getElementById(id + "-edit-desc").setAttribute("class", "btn btn-success");
    document.getElementById(id + "-edit-desc").innerHTML = "<i class='fas fa-save'></i> Save";

    document.getElementById(id + "-archive").innerHTML = "<i class='fas fa-times'></i> Cancel";
    document.getElementById(id + "-archive").setAttribute("onclick", "cancelDesc(" + id + ")");

    document.getElementById(id + "-edit-name").setAttribute("style", "visibility: hidden;");
}

function cancelDesc(id) {
    document.getElementById(id + "-archive").innerHTML = "<i class='fas fa-trash-alt'></i> Archive";
    document.getElementById(id + "-archive").setAttribute("onclick", "archive(" + id + ")");

    document.getElementById(id + "-description").innerHTML = document.getElementById(id + "-newdesc").getAttribute("placeholder");
    document.getElementById(id + "-edit-desc").setAttribute("onclick", "startDescEdit(" + id + ")");
    document.getElementById(id + "-edit-desc").setAttribute("class", "btn btn-secondary");
    document.getElementById(id + "-edit-desc").innerHTML = "<i class='fas fa-pencil-alt'></i> Edit Description";

    document.getElementById(id + "-edit-name").setAttribute("style", "");

}

function archive(id) {
    $.ajax({
        url:"/rules/utils/functions.php", //the page containing php script
        type: "post", //request type,
        data: "archiveid=" + id,
        success:function(result){
            document.getElementById(id).remove();
        }
    });
}

function updateRules() {
    $.ajax({
        url:"/rules/utils/update.php", //the page containing php script
        type: "post", //request type,
        success:function(result){
            alert(result)
        }
    });
}

function editName(id) {
    var newname = document.getElementById(id + "-newname").value;
    if (newname === ""|| newname == null) {
        alert("You must specify a value.");
        return;
    }

    $.ajax({
        url:"/rules/utils/functions.php", //the page containing php script
        type: "post", //request type,
        data: "editnameid=" + id + "&name=" + newname,
        success:function(result){
            document.getElementById(id + "-archive").innerHTML = "<i class='fas fa-trash-alt'></i> Archive";
            document.getElementById(id + "-archive").setAttribute("onclick", "archive(" + id + ")");

            document.getElementById(id + "-name").innerHTML = newname;
            document.getElementById(id + "-edit-name").setAttribute("onclick", "startNameEdit(" + id + ")");
            document.getElementById(id + "-edit-name").setAttribute("class", "btn btn-secondary");
            document.getElementById(id + "-edit-name").innerHTML = "<i class='fas fa-pencil-alt'></i> Edit Name";

            //Make the edit desc reappear.
            document.getElementById(id + "-edit-desc").setAttribute("style", "");
        }
    });
}

function editDesc(id) {
    var newname = document.getElementById(id + "-newdesc").value;
    if (newname === ""|| newname == null) {
        alert("You must specify a value.");
        return;
    }

    $.ajax({
        url:"/rules/utils/functions.php", //the page containing php script
        type: "post", //request type,
        data: "editdescid=" + id + "&desc=" + encodeURIComponent(newname),
        success:function(result){
            document.getElementById(id + "-archive").innerHTML = "<i class='fas fa-trash-alt'></i> Archive";
            document.getElementById(id + "-archive").setAttribute("onclick", "archive(" + id + ")");

            document.getElementById(id + "-description").innerHTML = newname;
            document.getElementById(id + "-edit-desc").setAttribute("onclick", "startDescEdit(" + id + ")");
            document.getElementById(id + "-edit-desc").setAttribute("class", "btn btn-secondary");
            document.getElementById(id + "-edit-desc").innerHTML = "<i class='fas fa-pencil-alt'></i> Edit Description";

            document.getElementById(id + "-edit-name").setAttribute("style", "");
        }
    });
}

function newrule(type) {
    var elementExists = document.getElementById("new");
    if (elementExists != null) {
        return;
    }

    document.getElementById("table-values").innerHTML += "<tr id='new' style='color:white'><td id='new-id'>-</td><td id='new-name-table'><input class='form-control mr-sm-2' type='text' placeholder='Some Rule' id='new-name'></td><td id='new-desc-table'><input class='form-control mr-sm-2' type='text' placeholder='Some Description' id='new-desc'></td><td id='new-weight-table'><select class='form-control' id='new-weight''><option>1 - Light</option><option>2 - Medium</option><option>3 - Heavy</option><option>4 - Severe</option><option>5 - Extreme</option></select></td><td id='new-warning-table'><div class='checkbox'><label><input type='checkbox' value='' id='new-warning'>Requires Warning</label></div></td><td id='new-buttons'><button type='button' class='btn btn-success' id='new-save' onclick='saveNew(" + type + ")'><i class='fas fa-save'></i> Save</button> <button type='button' class='btn btn-danger' id='new-cancel' onclick='newCancel()'><i class='fas fa-times'></i> Cancel</button></td></tr>"
}

function newCancel() {
    document.getElementById("new").remove();
}

function saveNew(type) {
    if (document.getElementById("new-name").value === ""||document.getElementById("new-name").value == null || document.getElementById("new-desc").value === ""||document.getElementById("new-desc").value == null) {
        return;
    }

    let newname = document.getElementById("new-name").value
    let newdesc = document.getElementById("new-desc").value
    let weight = parseInt(document.getElementById("new-weight").value.split(" - ")[0]);
    let requires_warning = document.getElementById("new-warning").value

    $.ajax({
        url:"/rules/utils/functions.php", //the page containing php script
        type: "post", //request type,
        data: "newname=" + newname + "&desc=" + encodeURIComponent(newdesc) + "&weight=" + weight + "&type=" + type + "&warning=" + requires_warning,
        success:function(result){
            document.getElementById("new-id").innerHTML = result;
            document.getElementById("new-id").setAttribute("id", result + "-id");

            document.getElementById("new-name-table").innerHTML = document.getElementById("new-name").value;
            document.getElementById("new-name-table").setAttribute("id",result + "-name");

            document.getElementById("new-desc-table").innerHTML = document.getElementById("new-desc").value;
            document.getElementById("new-desc-table").setAttribute("id",result + "-desc");

            document.getElementById("new-weight-table").innerHTML = document.getElementById("new-weight").value.split(" - ")[1];
            document.getElementById("new-weight-table").setAttribute("id",result + "-weight");

            let warning = "";
            if (document.getElementById("new-warning").value) {
                warning = "<strong>Yes</strong>";
            } else {
                warning = "<strong>No</strong>";
            }
            document.getElementById("new-warning-table").innerHTML = warning;
            document.getElementById("new-warning-table").setAttribute("id",result + "-warning");

            document.getElementById("new-buttons").innerHTML = "<button type='button' class='btn btn-secondary' id='" + result + "-edit-name' onclick='startNameEdit(" + result + ")'><i class='fas fa-pencil-alt'></i> Edit Name</button><button type='button' class='btn btn-secondary' id='" + result + "-edit-desc' onclick='startDescEdit(" + result + ")'><i class='fas fa-pencil-alt'></i> Edit Description</button><button type='button' class='btn btn-secondary' id='" + result + "-toggle-warning' onclick='toggleWarning(" + result + ")'><i class='fas fa-pencil-alt'></i> Toggle Warning</button><button type='button' class='btn btn-danger' id='" + result + "-archive' onclick='archive(" + result + ")'><i class='fas fa-trash-alt'></i> Archive</button>";
            document.getElementById("new-buttons").setAttribute("id", "");

            document.getElementById("new").setAttribute("id", result);
        }
    });
}

let weights = ["<Strong style='color:#00AA00;font-weight: bold'>Light</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Medium</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Heavy</Strong>", "<Strong style='font-weight: bold;color:#FFAA00'>Severe</Strong>", "<Strong style='font-weight: bold;color:#AA0000'>Extreme</Strong>"];
let types = ["<Strong style='color:#00AA00;font-weight: bold'>Chat</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Game</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Misc</Strong>"];
let requires_warnings = ["<Strong style='font-weight: bold'>No</Strong>","<Strong style='font-weight: bold'>Yes</Strong>"];
function loadRules(type) {
    $.ajax({
        url:'/rules/utils/get-rules.php',
        data: 'type=' + type,
        type: 'get',
        success: function(result) {
            result = JSON.parse(result);

            let table = document.getElementById("table-values");
            result.forEach(function (rule) {
                let elem = document.createElement("tr");
                table.appendChild(elem);

                let html = '"<tr id="' + rule["id"] +  '" style=\'color:white\'>' +
                    '<td id="' + rule["id"] +  '-id">' + rule["id"] + '</td>' +
                    '<td id="' + rule["id"] +  '-name">' + rule["name"] + '</td>' +
                    '<td id="' + rule["id"] +  '-description">' + rule["description"] + '</td>' +
                    '<td id="' + rule["id"] +  '-weight">' + weights[rule["weight"]] + '</td>' +
                    '<td id="' + rule["id"] +  '-warning">' + requires_warnings[rule["warning"]] + '</td>' +
                    '<td><button type=\'button\' class=\'btn btn-secondary\' id="' + rule["id"] +  '-edit-name" onclick=\'startNameEdit(' + rule["id"] +  ')\'><i class=\'fas fa-pencil-alt\'></i> Edit Name</button><button type=\'button\' class=\'btn btn-secondary\' id="' + rule["id"] +  '-edit-desc" onclick=\'startDescEdit(' + rule["id"] +  ')\'><i class=\'fas fa-pencil-alt\'></i> Edit Description</button><button type=\'button\' class=\'btn btn-secondary\' id="' + rule["id"] +  '-toggle-warning" onclick=\'toggleWarning(' + rule["id"] +  ')\'><i class=\'fas fa-pencil-alt\'></i> Toggle Warning</button><button type=\'button\' class=\'btn btn-danger\' id="' + rule["id"] +  '-archive" onclick=\'archive(' + rule["id"] +  ')\'><i class=\'fas fa-trash-alt\'></i> Archive</button></td></tr>"';
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

function loadArchive() {
    $.ajax({
        url:'/rules/utils/get-archive.php',
        type: 'get',
        success: function(result) {
            result = JSON.parse(result);

            let table = document.getElementById("table-values");
            result.forEach(function (rule) {
                let elem = document.createElement("tr");
                table.appendChild(elem);

                let html = '"<tr id="' + rule["id"] +  '" style=\'color:white\'>' +
                    '<td id="' + rule["id"] +  '-id">' + rule["id"] + '</td>' +
                    '<td id="' + rule["id"] +  '-name">' + rule["name"] + '</td>' +
                    '<td id="' + rule["id"] +  '-description">' + rule["description"] + '</td>' +
                    '<td id="' + rule["id"] +  '-type">' + types[rule["type"]] + '</td>' +
                    '<td id="' + rule["id"] +  '-weight">' + weights[rule["weight"]] + '</td>' +
                    '<td id="' + rule["id"] +  '-warning">' + requires_warnings[rule["warning"]] + '</td></tr>"';
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

function toggleWarning(id) {
    $.ajax({
        url:"/rules/utils/functions.php", //the page containing php script
        type: "post", //request type,
        data: "togglewarning=" + id,
        success:function(result){
            document.getElementById(id + "-warning").innerHTML = result;
        }
    });
}