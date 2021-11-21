function networkChangeServerCreate(network) {
    if (network === 'TEST') {
        document.getElementById("extra_create_server").style.visibility = "visible";
        document.getElementById("extra_create_server").style.display = "block";
    } else {
        document.getElementById("extra_create_server").style.visibility = "hidden";
        document.getElementById("extra_create_server").style.display = "none";
    }
}

function networkChangeProxyCreate(network) {
    if (network === 'TEST') {
        document.getElementById("extra_create_proxy").style.visibility = "visible";
        document.getElementById("extra_create_proxy").style.display = "block";
    } else {
        document.getElementById("extra_create_proxy").style.visibility = "hidden";
        document.getElementById("extra_create_proxy").style.display = "none";
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

function proxyCreate(network, extradetails) {
    document.getElementById("create-proxy-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/proxy/create.php',
        type: 'post',
        data: "network=" + encodeURIComponent(network) + "&extradetails=" + encodeURIComponent(extradetails),
        success: function(result) {
            alert(result);
            document.getElementById("create-proxy-button").disabled = false;
        }
    });
}

function proxyClose(server, network) {
    document.getElementById("close-proxy-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/proxy/close.php',
        type: 'post',
        data: "proxy=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("close-proxy-button").disabled = false;
        }
    });
}

function proxyRestart(server, network) {
    document.getElementById("restart-proxy-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/proxy/restart.php',
        type: 'post',
        data: "proxy=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("restart-proxy-button").disabled = false;
        }
    });
}