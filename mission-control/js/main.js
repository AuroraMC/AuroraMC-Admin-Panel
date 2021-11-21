function networkChangeServerCreate(network) {
    if (network === 'MAIN') {
        document.getElementById("extra_create_server").style.visibility = "hidden";
        document.getElementById("extra_create_server").style.display = "none";
    } else {
        document.getElementById("extra_create_server").style.visibility = "visible";
        document.getElementById("extra_create_server").style.display = "block";
    }
}

function serverCreate(server, network, game, extradetails) {
    document.getElementById("create-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/server/create.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network) + "&game=" + encodeURIComponent(game) + "&extradetails=" + encodeURIComponent(extradetails),
        success: function(result) {
            alert(result);
            document.getElementById("create-server-button").disabled = false;
        }
    });
}

function serverClose(server, network) {
    document.getElementById("close-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/server/close.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("close-server-button").disabled = false;
        }
    });
}

function serverRestart(server, network) {
    document.getElementById("restart-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/server/restart.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("restart-server-button").disabled = false;
        }
    });
}