/*
 * Copyright (c) 2022-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
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
        },
        error: function(err) {

        }
    });
}