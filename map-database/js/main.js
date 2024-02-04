/*
 * Copyright (c) 2022-2024 Ethan P-B. All Rights Reserved.
 */

function addNewMap(id) {
    document.getElementById("map-" + id).remove();
    $.ajax({
        url:'/map-database/util/functions.php',
        type: 'post',
        data: "addNew=" + encodeURIComponent(id),
        success: function(result) {
        }
    });
}

function removeNewMap(id) {
    document.getElementById("map-" + id).remove();
    $.ajax({
        url:'/map-database/util/functions.php',
        type: 'post',
        data: "removeNew=" + encodeURIComponent(id),
        success: function(result) {
        }
    });
}

function addOldMap(id) {
    document.getElementById("map-" + id).remove();
    $.ajax({
        url:'/map-database/util/functions.php',
        type: 'post',
        data: "addOld=" + encodeURIComponent(id),
        success: function(result) {
        }
    });
}

function removeOldMap(id) {
    document.getElementById("map-" + id).remove();
    $.ajax({
        url:'/map-database/util/functions.php',
        type: 'post',
        data: "removeOld=" + encodeURIComponent(id),
        success: function(result) {
        }
    });
}

function onLoad() {
    $.ajax({
        url:'/map-database/util/total-live.php',
        type: 'post',
        success: function(result) {
            document.getElementById("live").innerText = result;
            $.ajax({
                url:'/map-database/util/total-parsed.php',
                type: 'post',
                success: function(result) {
                    document.getElementById("parsed").innerText = result;
                    document.getElementById("content").style.display = null;
                    document.getElementById("ring").style.display = "none";
                }
            });
        }
    });
}

function onLoadLive() {
    $.ajax({
        url:'/map-database/util/get-live.php',
        type: 'post',
        success: function(result) {
            let maps = JSON.parse(result);
            let table = document.getElementById("table-values");
            maps.forEach(function (map) {
                let row = document.createElement("tr");
                table.appendChild(row)
                row.id = "map-" + map["id"];
                row.innerHTML = "<td>" + map["id"] + "</td>" +
                    "<td>" + map["parse_number"] + "</td>" +
                    "<td>" + map["name"] + "</td>" +
                    "<td>" + map["author"] + "</td>" +
                    "<td>" + map["game"] + "</td>" +
                    "<td>" + map["world_name"] + "</td>" +
                    "<td><button type=\"button\" class=\"btn btn-danger\" onclick='removeOldMap(" + map["id"] + ")'><i class=\"fas fa-trash-alt\"></i> Remove</button></td>"
            })

            document.getElementById("content").style.display = null;
            $('#dtLive').DataTable({
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

function onLoadParsed() {
    $.ajax({
        url:'/map-database/util/get-parsed.php',
        type: 'post',
        success: function(result) {
            let maps = JSON.parse(result);
            let table = document.getElementById("table-values");
            maps.forEach(function (map) {
                let row = document.createElement("tr");
                table.appendChild(row)
                row.id = "map-" + map["id"];
                row.innerHTML = "<td>" + map["id"] + "</td>" +
                    "<td>" + map["parse_number"] + "</td>" +
                    "<td>" + map["name"] + "</td>" +
                    "<td>" + map["author"] + "</td>" +
                    "<td>" + map["game"] + "</td>" +
                    "<td>" + map["world_name"] + "</td>" +
                    "<td><button type=\"button\" class=\"btn btn-success\" onclick='addNewMap(" + map["id"] + ")'><i class=\"fas fa-plus\"></i> Add</button></td>"
            })

            document.getElementById("content").style.display = null;
            $('#dtParsed').DataTable({
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

function onLoadUpdate() {
    $.ajax({
        url:'/map-database/util/get-update.php',
        type: 'post',

        success: function(result) {
            let changes = JSON.parse(result);
            let table = document.getElementById("table-values");
            if (changes["additions"] !== "NONE") {
                let additions = changes["additions"];
                additions.forEach(function (map) {
                    let row = document.createElement("tr");
                    table.appendChild(row)
                    row.id = "map-" + map["id"];
                    row.innerHTML = "<td>" + map["id"] + "</td>" +
                        "<td>" + map["parse_number"] + "</td>" +
                        "<td>" + map["name"] + "</td>" +
                        "<td>" + map["author"] + "</td>" +
                        "<td>" + map["game"] + "</td>" +
                        "<td>" + map["world_name"] + "</td>" +
                        "<td><strong style='color:#00AA00;font-weight: bold'>Addition</strong></td>" +
                        "<td><button type=\"button\" class=\"btn btn-danger\" onclick='removeNewMap(" + map["id"] + ")'><i class=\"fas fa-trash-alt\"></i> Remove From Update</button></td>"
                })
            }

            if (changes["removals"] !== "NONE") {
                let removals = changes["removals"];
                removals.forEach(function (map) {
                    let row = document.createElement("tr");
                    table.appendChild(row)
                    row.id = "map-" + map["id"];
                    row.innerHTML = "<td>" + map["id"] + "</td>" +
                        "<td>" + map["parse_number"] + "</td>" +
                        "<td>" + map["name"] + "</td>" +
                        "<td>" + map["author"] + "</td>" +
                        "<td>" + map["game"] + "</td>" +
                        "<td>" + map["world_name"] + "</td>" +
                        "<td><strong style='color:#AA0000;font-weight: bold'>Removal</strong></td>" +
                        "<td><button type=\"button\" class=\"btn btn-danger\" onclick='addOldMap(" + map["id"] + ")'><i class=\"fas fa-trash-alt\"></i> Remove From Update</button></td>"
                })
            }

            document.getElementById("content").style.display = null;
            $('#dtParsed').DataTable({
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

function pushUpdate() {
    $.ajax({
        url:'/map-database/util/push.php',
        type: 'post',
        success: function(result) {
            alert(result);
        },
        error: function(err) {

        }
    });
}