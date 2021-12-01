/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

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

function enableNetwork(network) {
    document.getElementById("enable-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/network/enable.php',
        type: 'post',
        data: "network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("enable-button").disabled = false;
        }
    });
}

function disableNetwork(network) {
    document.getElementById("disable-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/network/disable.php',
        type: 'post',
        data: "network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("disable-button").disabled = false;
        }
    });
}

function updateNetwork(core, lobby, engine, game, build, event, proxy) {
    let modules = [];
    if (core !== "") {
        modules.push("core:" + core);
    }
    if (lobby !== "") {
        modules.push("lobby:" + lobby);
    }
    if (engine !== "") {
        modules.push("engine:" + engine);
    }
    if (game !== "") {
        modules.push("game:" + game);
    }
    if (build !== "") {
        modules.push("build:" + build);
    }
    if (event !== "") {
        modules.push("event:" + event);
    }
    if (proxy !== "") {
        modules.push("proxy:" + proxy);
    }
    document.getElementById("update-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/network/update.php',
        type: 'post',
        data: "data=" + encodeURIComponent(modules.join(";")),
        success: function(result) {
            alert(result);
            document.getElementById("update-button").disabled = false;
            $('#updateModal').modal('hide');
        }
    });
}

function enableAlpha() {
    document.getElementById("enable-alpha-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/alpha/enable.php',
        type: 'post',
        success: function(result) {
            alert(result);
            document.getElementById("enable-alpha-button").disabled = false;
        }
    });
}

function disableAlpha() {
    document.getElementById("disable-alpha-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/alpha/disable.php',
        type: 'post',
        success: function(result) {
            alert(result);
            document.getElementById("disable-alpha-button").disabled = false;
        }
    });
}

function updateAlphaNetwork(core, lobby, engine, game, build, event, proxy) {
    let modules = [];
    if (core !== "") {
        modules.push("core;" + core);
    }
    if (lobby !== "") {
        modules.push("lobby;" + lobby);
    }
    if (engine !== "") {
        modules.push("engine;" + engine);
    }
    if (game !== "") {
        modules.push("game;" + game);
    }
    if (build !== "") {
        modules.push("build;" + build);
    }
    if (event !== "") {
        modules.push("event;" + event);
    }
    if (proxy !== "") {
        modules.push("proxy;" + proxy);
    }
    document.getElementById("update-alpha-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/alpha/update.php',
        type: 'post',
        data: "data=" + encodeURIComponent(modules.join(",")),
        success: function(result) {
            alert(result);
            document.getElementById("update-alpha-button").disabled = false;
            $('#alphaModal').modal('hide');
        }
    });
}

function enableGame(game, network) {
    document.getElementById("enable-game-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/game/enable.php',
        type: 'post',
        data: "game=" + encodeURIComponent(game) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("enable-game-button").disabled = false;
        }
    });
}

function disableGame(game, network) {
    document.getElementById("disable-game-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/game/disable.php',
        type: 'post',
        data: "game=" + encodeURIComponent(game) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("disable-game-button").disabled = false;
        }
    });
}

function monitoringToggle(enabled, game, network) {
    document.getElementById("monitoring-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/game/monitor.php',
        type: 'post',
        data: "enabled=" + encodeURIComponent(enabled) + "&game=" + encodeURIComponent(game) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("monitoring-button").disabled = false;
        }
    });
}

function maintenanceMode(network, mode) {
    document.getElementById("maintenance-mode-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/maintenance/mode.php',
        type: 'post',
        data: "mode=" + encodeURIComponent(mode) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("maintenance-mode-button").disabled = false;
        }
    });
}

function maintenanceMotd(network, motd) {
    document.getElementById("maintenance-motd-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/maintenance/maintenance-motd.php',
        type: 'post',
        data: "motd=" + encodeURIComponent(motd) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("maintenance-motd-button").disabled = false;
        }
    });
}

function normalMotd(network, motd) {
    document.getElementById("normal-motd-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/maintenance/normal-motd.php',
        type: 'post',
        data: "motd=" + encodeURIComponent(motd) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("normal-motd-button").disabled = false;
        }
    });
}