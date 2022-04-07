/*
 * Copyright (c) 2022 AuroraMC Ltd. All Rights Reserved.
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

function pushUpdate() {
    $.ajax({
        url:'/map-database/util/push.php',
        type: 'post',
        success: function(result) {
            alert(result);
        }
    });
}